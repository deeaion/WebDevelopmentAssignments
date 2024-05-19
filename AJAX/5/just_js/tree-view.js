document.addEventListener("DOMContentLoaded", function() {
    const treeViewElement = document.getElementById('tree-view');
    const fileContentElement = document.getElementById('file-content');

    function fetchDirectory(path, parentElement) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `server.php?path=${encodeURIComponent(path)}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                renderDirectory(parentElement, data, path);
            } else {
                console.error("Failed to load directory:", xhr.status);
            }
        };
        xhr.send();
    }

    function fetchFile(path) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `server.php?path=${encodeURIComponent(path)}`, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                fileContentElement.innerText = xhr.responseText;
            } else {
                console.error("Failed to load file:", xhr.status);
            }
        };
        xhr.send();
    }

    function renderDirectory(container, data, basePath) {
        const ul = document.createElement('ul');
        data.forEach(item => {
            const li = document.createElement('li');
            li.textContent = basePath !== '.' ? basePath + '/' + item.name : item.name;
            li.dataset.path = item.path;
            if (item.type === 'directory') {
                li.addEventListener('click', function(event) {
                    event.stopPropagation();
                    const childUl = li.querySelector('ul');

                    // Toggle the selected class and remove previous children
                    if (!li.classList.contains('selected')) {
                        // Remove selected class from any other li elements at the same level
                        const siblingLis = container.querySelectorAll('li');
                        siblingLis.forEach(siblingLi => {
                            if (siblingLi !== li && siblingLi.classList.contains('selected')) {
                                siblingLi.classList.remove('selected');
                                const siblingChildUl = siblingLi.querySelector('ul');
                                if (siblingChildUl) {
                                    siblingChildUl.remove();
                                }
                            }
                        });

                        li.classList.add('selected');
                    } else {
                        li.classList.remove('selected');
                    }

                    if (!childUl) {
                        fetchDirectory(item.path, li);
                    } else {
                        childUl.style.display = childUl.style.display === 'none' ? 'block' : 'none';
                    }
                });
            } else if (item.type === 'file') {
                li.addEventListener('click', function(event) {
                    event.stopPropagation();
                    fetchFile(li.dataset.path);
                });
            }
            ul.appendChild(li);
        });
        container.appendChild(ul);
    }

    // Fetch the root directory initially
    fetchDirectory('.', treeViewElement);
});
