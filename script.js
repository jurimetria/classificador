<script type="text/javascript">
document.getElementById("outraPasta").onclick = function () {
    location.href = "index.php";
};


function goBack() {
window.history.back();
}

    document.getElementById("voltar").onclick = function () {
    window.location.href="sistema.php?id_pasta="+'<?php echo $db_v['id_pasta'];?>';}

document.getElementById("voltar").onclick = function () {
window.location.href="sistema.php?id_pasta="+'<?php echo $db_f['id_pasta'];?>';}





</script>