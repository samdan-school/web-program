htmlCode = '';

window.onload = () => {
    html = document.getElementsByTagName("html")[0];

    node = document.createElement("DIV");
    node.className = "infoDiv";
    document.getElementsByTagName("body")[0].appendChild(node);

    find_child(html);
    node.innerHTML = (htmlCode);
}

function find_child(element, txt) {
    children = element.childNodes;

    if (children.length > 0) {
        children.forEach(child => {
            renderInfo(child);
            find_child(child);
        });
    }
}

function renderInfo(element) {
    var tag = '';
    var attrs = element.attributes;
    var my_attrs = '';

    if (element.nodeName == "#text") {
        // tag = element.data;
        return;
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
    htmlCode += "<div>" + tag + my_attrs + "</div>";
}

