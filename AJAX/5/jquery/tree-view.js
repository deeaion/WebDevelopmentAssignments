$(document).ready(function() {
    const $treeViewElement = $('#tree-view');
    const $fileContentElement = $('#file-content');

    function fetchDirectory(path, $parentElement) {
        $.ajax({
            url: 'server.php',
            method: 'GET',
            data: { path: path },
            success: function(data) {
                console.log("Directory data:", data); // Log the data
                if (typeof data === "string") {
                    try {
                        data = JSON.parse(data);
                    } catch (e) {
                        console.error("Failed to parse JSON:", e);
                        return;
                    }
                }
                renderDirectory($parentElement, data, path);
            },
            error: function(xhr, status, error) {
                console.error("Failed to load directory:", xhr.status);
            }
        });
    }

    function fetchFile(path) {
        $.ajax({
            url: 'server.php',
            method: 'GET',
            data: { path: path },
            success: function(data) {
                $fileContentElement.text(data);
            },
            error: function(xhr, status, error) {
                console.error("Failed to load file:", xhr.status);
            }
        });
    }

    function renderDirectory($container, data, basePath) {
        const $ul = $('<ul></ul>');
        data.forEach(item => {
            const itemPath = basePath !== '.' ? `${basePath}/${item.name}` : item.name;
            const $li = $('<li></li>').text(item.name).data('path', itemPath);

            if (item.type === 'directory') {
                $li.on('click', function(event) {
                    event.stopPropagation();
                    const $childUl = $li.children('ul');

                    if (!$li.hasClass('selected')) {
                        $li.siblings().removeClass('selected').children('ul').remove();
                        $li.addClass('selected');
                    } else {
                        $li.removeClass('selected');
                    }

                    if ($childUl.length === 0) {
                        fetchDirectory(itemPath, $li);
                    } else {
                        $childUl.toggle();
                    }
                });
            } else if (item.type === 'file') {
                $li.on('click', function(event) {
                    event.stopPropagation();
                    fetchFile(itemPath);
                });
            }

            $ul.append($li);
        });
        $container.append($ul);
    }

    // Fetch the root directory initially
    fetchDirectory('.', $treeViewElement);
});
