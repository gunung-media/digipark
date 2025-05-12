import { onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

export function useToastFlash() {
    onMounted(() => {
        const flash = usePage().props.flash as {
            success?: string;
            error?: string;
        };

        if (flash.success) {
            toast.success(flash.success);
        }

        if (flash.error) {
            toast.error(flash.error);
        }
    });
}
