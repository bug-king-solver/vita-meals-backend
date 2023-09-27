import Swal from "sweetalert2";
import { FlashOptions } from "../types";

// This is a very basic composable module
export function useFlash() {
    function flash({ iconType, title, message }: FlashOptions) {
        Swal.fire({
            icon: iconType,
            title: title,
            text: message
        });
    }

    return { flash };
}