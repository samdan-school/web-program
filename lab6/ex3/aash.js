window.onload = () => {
    html = document.getElementsByTagName("html")[0];

    find_child(html);
}

function find_child(element) {
    children = element.childNodes;

    node = document.createElement("DIV");
    node.className = "infoDiv";
    document.getElementsByTagName("body")[0].appendChild(node);

    if (children.length > 0) {
        children.forEach(child => {
            renderInfo(child, node);
            find_child(element);
        });
    }

    return;
}

function renderInfo(element, html) {
    var tag = '';
    var attrs = element.attributes;
    var my_attrs = '';

    if (element.nodeName == "#text") {
        tag = element.data;
    } else {
        tag = '+' + element.tagName;
    }

    if (attrs != undefined && attrs.length > 0) {
        my_attrs += '[';
        for (i = 0; i < attrs.length; i++) {
            my_attrs += attrs[i].name + "=" + attrs[i].value + "; ";
        }
        my_attrs += ']';
    }
    var node = document.createElement("DIV");

    node.innerHTML = tag + my_attrs;
    html.appendChild(node)
}

