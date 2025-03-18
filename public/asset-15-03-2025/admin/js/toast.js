    function showToast(messageText, messageDetailText) {
        // Create the toast div element
        let toast = document.createElement('div');
        toast.id = "toast";
        toast.style.position = 'relative';
        // toast.style.bottom = '20px';
        toast.style.left = '50%';
        // toast.style.transform = 'translateX(0)';
        // toast.style.backgroundColor = '#fff';
        // toast.style.color = '#444';
        // toast.style.padding = '10px 20px';
        // toast.style.borderRadius = '5px';
        // toast.style.display = 'flex';
        // toast.style.alignItems = 'center';
        // toast.style.gap = '10px';
        toast.style.zIndex = '9999';

        // Container 1 with icon
        let container1 = document.createElement('div');
        container1.classList.add('container-1');
        let icon = document.createElement('i');
        icon.classList.add('fas', 'fa-check-square');
        icon.style.color = 'green';
        container1.appendChild(icon);

        // Container 2 with message and details
        let container2 = document.createElement('div');
        container2.classList.add('container-2');
        let message = document.createElement('p');
        message.textContent = messageText;
        let messageDetail = document.createElement('p');
        messageDetail.textContent = messageDetailText;
        container2.appendChild(message);
        container2.appendChild(messageDetail);

        // Close button
        let closeButton = document.createElement('button');
        closeButton.id = "close";
        closeButton.innerHTML = "&times;";
        closeButton.style.marginLeft = 'auto';
        closeButton.style.background = 'transparent';
        closeButton.style.border = 'none';
        closeButton.style.fontSize = '18px';
        closeButton.style.cursor = 'pointer';
        closeButton.addEventListener('click', () => {
            closeToast(toast);
        });

        // Append all elements to the toast
        toast.appendChild(container1);
        toast.appendChild(container2);
        toast.appendChild(closeButton);

        // Append the toast to the body
        document.body.appendChild(toast);

        // Automatically close the toast after 4 seconds
        setTimeout(() => {
            closeToast(toast);
        }, 4000);

        return toast;
    }

    function closeToast(toastElement) {
        toastElement.style.transform = "translateX(400px)";
        setTimeout(() => {
            if (toastElement && toastElement.parentNode) {
                toastElement.parentNode.removeChild(toastElement);
            }
        }, 500);  // Give some time for the animation to finish
    }
