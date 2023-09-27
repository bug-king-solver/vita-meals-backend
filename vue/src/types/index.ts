export interface Product {
    id: number;
    title: string;
    description: string;
    image_url: string;
    price: number;
}

export interface ProductsState {
    products: Product[]
}

export interface RootState {

}

export interface FlashOptions {
    iconType: any;
    title: string;
    message: string;
}

export interface SignInPayload {
    email: string;
    password: string;
}

export interface CartItem {
    product: Product;
    quantity: number;
}

export interface CartItemPayload {
    cart_id: number;
    product_id: number;
}

export interface RemoveCartItemPayload {
    cart_id: number;
}