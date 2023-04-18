</div>
</div>

<script src="http://tasklist.localhost:8080/assets/js/jquery.min.js"></script>
<script src="http://tasklist.localhost:8080/assets/js/popper.js"></script>
<script src="http://tasklist.localhost:8080/assets/js/bootstrap.min.js"></script>
<script src="http://tasklist.localhost:8080/assets/js/main.js"></script>
<script src="https://code.jquery.com"></script>
<script>
    document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var estado = checkbox.checked;
            if (checkbox.id != 'showAll') {
                if (estado) {
                    completarTarea(this.dataset.id, this.dataset.id_usuario, estado);
                }
                else {
                    
                    completarTarea(this.dataset.id, this.dataset.id_usuario, estado);
                }
                
            }



        });
    });
    var showAll = document.getElementById('showAll');

    showAll.addEventListener('change', function () {
        value = showAll.checked;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo base_url() ?>getCompleted', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                location.reload();
            }
        };
        console.log(value);
        xhr.send('showAll=' + value);


    });


    function completarTarea(id, id_usuario, showAll) {
        var xhr = new XMLHttpRequest();
        var id_estado = showAll ? '2' : '1';
        xhr.open('POST', '<?php echo base_url() ?>complete', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                location.reload();
            }
        };
        var data = 'id=' + id + '&id_usuario=' + id_usuario + '&id_estado=' + id_estado;
        console.log(data);
        xhr.send(data);


    }

</script>
</body>

</html>