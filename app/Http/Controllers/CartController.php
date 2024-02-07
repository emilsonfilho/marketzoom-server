<?php

namespace App\Http\Controllers;

use App\Exceptions\NotAllowedException;
use App\Http\Requests\CheckoutItemRequest;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Gate;
use Knuckles\Scribe\Attributes\Group;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Group(name: 'Carrinhos', description: 'Gestão dos carrinhos')]
class CartController extends Controller
{
    /**
     * GET api/cart
     *
     * Display the cart of the logged user.
     */
    public function index(): JsonResponse
    {
        if (Gate::denies('is-user')) return NotAllowedException::notAllowed();

        return response()->json($this->getUserCart());
    }

    /**
     * POST api/cart/add-item/{product}
     *
     * Store a newly created resource in storage.
     */
    public function addItem(ItemRequest $request, Product $product): JsonResponse
    {
        if (Gate::denies('is-user')) return NotAllowedException::notAllowed();

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['product_id'] = $product->id;

        $cart = Cart::where('product_id', $product->id);
        $current_product_stock = $product->stock_quantity;
        $quantity_ordered = $data['product_quantity'];

        if ($current_product_stock < $quantity_ordered)
            return response()->json(['error' => 'Você não pode pedir a mais do que tem no estoque!']);

        $product->update([
            'stock_quantity' => $current_product_stock - $quantity_ordered,
        ]);

        if ($cart->exists()) {
            $cart->update([
                'product_quantity' => $cart->first()->product_quantity + $quantity_ordered,
            ]);
        } else {
            $cart = Cart::create($data);
        }

        return response()->json($this->getUserCart());
    }

    /**
     * DELETE api/cart/remove-item/{product}
     *
     * Remove an item from the cart
     */
    public function removeItem(ItemRequest $request, Product $product): JsonResponse
    {
        if (Gate::denies('is-user')) return NotAllowedException::notAllowed();

        $data = $request->validated();

        $product_cart = $this->getCartField($product->id);
        $quantity_ordered = $product_cart->product_quantity;
        $current_product_stock = $product->stock_quantity;
        $quantity_to_exclude = $data['product_quantity'];

        if ($quantity_to_exclude > $quantity_ordered) {
            return response()->json([
                'error' => 'Você não pode excluir um número acima do que pediu.'
            ]);
        } else if ($quantity_to_exclude == $quantity_ordered) {
            $product->update([
                'stock_quantity' => $current_product_stock + $quantity_ordered,
            ]);

            $product_cart->delete();
        } else {
            $product_cart->update([
                'product_quantity' => $quantity_ordered - $quantity_to_exclude,
            ]);

            $product->update([
                'stock_quantity' => $current_product_stock + $quantity_to_exclude,
            ]);
        }

        return response()->json($this->getUserCart());
    }

    /**
     * DELETE api/cart/remove-product/{product}
     *
     * Removes the entirely product from the cart
     */
    public function removeProduct(Product $product): JsonResponse
    {
        if (Gate::denies('is-user')) return NotAllowedException::notAllowed();

        $cart = $this->getCartField($product->id);

        $returned_quantity = $cart->product_quantity;

        $product->update([
            'stock_quantity' => $product->stock_quantity + $returned_quantity,
        ]);

        $cart->delete();

        return response()->json($this->getUserCart());
    }

    /**
     * PUT api/cart/checkout/product/{product}
     *
     * Checkout a product
     */
    public function checkoutProduct(Product $product): JsonResponse
    {
        if (Gate::denies('is-user')) return NotAllowedException::notAllowed();

        $cart_field = $this->getCartFieldQuery($product->id);

        $cart_field->update([
            'finished' => true,
        ]);

        return response()->json($this->getUserCart());
    }

    /**
     * PUT api/cart/checkout/item/{product}
     */
    public function checkoutItem(CheckoutItemRequest $request, Product $product): JsonResponse
    {
        if (Gate::denies('is-user')) return NotAllowedException::notAllowed();

        $quantity_to_buy = $request->validated('quantity');

        $cart_field_query = $this->getCartFieldQuery($product->id);
        $quantity_ordered = $cart_field_query->first()->product_quantity;

        if ($quantity_to_buy > $quantity_ordered) {
            return response()->json([
                'error' => 'Você não pode comprar um número acima do que pediu.'
            ]);
        } else if ($quantity_to_buy == $quantity_ordered) {
            $cart_field_query->update([
                'finished' => true
            ]);
        } else {
            $cart_field_query->update([
                'product_quantity' => $quantity_ordered - $quantity_to_buy,
            ]);

            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'product_quantity' => $quantity_to_buy,
                'finished' => true,
            ]);
        }

        return response()->json($this->getUserCart());
    }

    /**
     * PUT api/cart/checkout/all
     *
     * Checkout all the products in the user's cart
     */
    public function checkout(): JsonResponse
    {
        if (Gate::denies('is-user')) return NotAllowedException::notAllowed();

        $cart = Cart::with('product')->where('user_id', auth()->id())->groupBy('user_id', 'carts.id')->update([
            'finished' => true,
        ]);

        return response()->json(CartResource::collection($this->getUserCart()));
    }

    private function getUserCart(): ResourceCollection
    {
        return CartResource::collection(Cart::with('product')->where('user_id', auth()->id())->where('finished', false)->groupBy('user_id', 'carts.id')->get());
    }

    private function getCartField(int $product_id) {
        return Cart::where('user_id', auth()->id())->where('product_id', $product_id)->where('finished', false)->first();
    }

    private function getUserCartQuery() {
        return Cart::with('product')->where('user_id', auth()->id())->where('finished', false);
    }

    private function getCartFieldQuery(int $product_id) {
        return Cart::where('user_id', auth()->id())->where('product_id', $product_id)->where('finished', false);
    }
}
