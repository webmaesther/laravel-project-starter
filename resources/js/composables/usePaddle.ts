import { usePage } from '@inertiajs/vue3';
import { CheckoutOpenOptions, initializePaddle, type Paddle as PaddleInterface } from '@paddle/paddle-js';
import { createSharedComposable } from '@vueuse/core';

const usePaddle = createSharedComposable(function usePaddle() {
    const page = usePage();

    let Paddle: PaddleInterface;

    const checkout = (options: CheckoutOpenOptions) => {
        initialize().then(() => {
            Paddle.Checkout.open(options);
        });
    };

    const initialize = async () => {
        const paddle = await initializePaddle(page.props.paddle);

        if (paddle === undefined) {
            throw Error('Paddle could not be initialized.');
        }

        Paddle = paddle;
    };

    return { checkout };
});

export { usePaddle };
