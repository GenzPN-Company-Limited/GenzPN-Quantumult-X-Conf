function pasteUrl() {
    navigator.clipboard.readText()
        .then(text => {
            document.getElementById('url').value = text;
        })
        .catch(err => {
            alert('Failed to paste URL: ' + err.message);
        });
}

function generateProfile() {
    const url = document.getElementById('url').value;
    if (!url) {
        swal('Error', 'Please enter a URL.', 'error');
        return;
    }

    const generateButton = document.querySelector('.generate');
    const pasteButton = document.querySelector('.paste');
    generateButton.disabled = true;
    pasteButton.disabled = true;

    fetch(`generate_profile.php?url=${encodeURIComponent(url)}`)
        .then(response => response.json())
        .then(data => {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '';
            if (data.error) {
                resultDiv.innerHTML = `<p style="color: red;">${data.error}</p>`;
            } else {
                const downloadLink = document.createElement('a');
                downloadLink.href = data.download_link;
                downloadLink.innerText = 'Download Config';
                downloadLink.className = 'button download';
                downloadLink.download = '';

                const copyButton = document.createElement('button');
                copyButton.innerText = 'Copy Link';
                copyButton.className = 'button copy';
                copyButton.onclick = () => copyToClipboard(data.download_link);

                const buttonGroup = document.createElement('div');
                buttonGroup.className = 'button-group';
                buttonGroup.appendChild(downloadLink);
                buttonGroup.appendChild(copyButton);

                resultDiv.appendChild(buttonGroup);

                generateButton.style.display = 'none';
                pasteButton.style.display = 'none';
            }
        })
        .catch(error => {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = `<p style="color: red;">An error occurred: ${error.message}</p>`;
        })
        .finally(() => {
            generateButton.disabled = false;
            pasteButton.disabled = false;
        });
}


function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
        .then(() => {
            swal({
                title: "Success",
                text: "Link copied!",
                icon: "success",
                button: {
                    text: "OK",
                    className: "swal-button--confirm"
                }
            }).then(() => {
                setTimeout(() => {
                    swal.close();
                }, 5000);
            });
        })
        .catch(err => {
            alert('Failed to copy link: ' + err.message);
        });
}
