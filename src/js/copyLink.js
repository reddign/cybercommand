window.addEventListener("load",init);

function init() {
    document.getElementById("copyLinkButton").addEventListener("click",copyToClipboard);
}

function copyToClipboard() {
    const link = document.getElementById("surveyLink").href;
    navigator.clipboard.writeText(link);
}