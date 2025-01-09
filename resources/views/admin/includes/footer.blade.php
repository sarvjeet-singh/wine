<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<script>
    /**
     * Display a toast notification
     * 
     * @param {string} heading - The title of the toast (e.g., "Success", "Error").
     * @param {string} text - The message to be displayed in the toast.
     * @param {string} icon - The type of toast ("success", "error", "info", "warning").
     * @param {string} position - The position of the toast ("top-right", "top-left", etc.).
     */
    function showToast(heading, text, icon = "info", position = "bottom-right") {
        $.toast({
            heading: heading,
            text: text,
            icon: icon,
            position: position,
            loader: true,
            loaderBg: icon === "success" ? "#9EC600" : "#f2a654",
            showHideTransition: "slide",
        });
    }
</script>
