import { useToast } from 'vue-toastification'
import Swal from "sweetalert2";

export const deleteRowTable = async (t, handler) => {
    try {
        const result = await Swal.fire({
            title: t("generics.tables.confirm.delete"),
            showDenyButton: true,
            confirmButtonText: t("generics.tables.confirm.confirmButton"),
            denyButtonText: t("generics.tables.confirm.denyButton"),
            confirmButtonColor: "#111827",
            cancelButtonColor: "#ffffff",
        });

        if (!result.isConfirmed) {
            return;
        }

        handler()
        const toast = useToast()
        toast.success(t("generics.messages.deleted_successfully"));
    } catch (error) {
        Swal.fire({
            icon: "error",
            text: t("generics.tables.errors.could_not_delete_the_record"),
        });
    }
};
