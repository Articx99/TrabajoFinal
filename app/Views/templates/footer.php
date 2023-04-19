</div>
</div>

<script src="http://tasklist.localhost:8080/assets/js/jquery.min.js"></script>
<script src="http://tasklist.localhost:8080/assets/js/popper.js"></script>
<script src="http://tasklist.localhost:8080/assets/js/bootstrap.min.js"></script>
<script src="http://tasklist.localhost:8080/assets/js/main.js"></script>
<script src="http://tasklist.localhost:8080/assets/js/anime.min.js"></script>
<script>

    document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            
            var estado = checkbox.checked;
            if (checkbox.id != 'showAll') {
                if (estado) {
                    completarTarea(this.dataset.id, this.dataset.id_usuario, this.dataset.username, estado);
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


    function deleteTarea(id, id_usuario, username, url) {
        console.log(url);
        var fila = document.querySelector(`.${username}${id}`);
        var xhr = new XMLHttpRequest();

        xhr.open('POST', `<?php echo base_url() ?>${url}`, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                var fila = document.querySelector('.' + username + id);
                anime({
                    targets: fila,
                    opacity: 0,
                    translateY: '50px',
                    backgroundColor: '#ff0000',
                    easing: 'easeInOutQuad',
                    duration: 1000,
                    complete: function () {
                        fila.remove(); // Elimina la fila una vez que la animación ha terminado
                    }
                });

            }
        };
        var data = 'id=' + id + '&id_usuario=' + id_usuario;
        xhr.send(data);
    }

    function completarTarea(id, id_usuario, username, showAll) {
        var xhr = new XMLHttpRequest();
        var id_estado = showAll ? '2' : '1';
        xhr.open('POST', '<?php echo base_url() ?>complete', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                var showAll = document.getElementById("showAll");
                var contenedorTabla = document.querySelector("#content");
                var fila = document.querySelector('.' + username + id);
                const animation = anime({
                    targets: fila,
                    translateX: '130%',
                    duration: 1500,
                    direction: showAll.checked ? 'alternate' : 'normal',
                    backgroundColor: '#90EE90',
                    easing: 'easeInOutSine',

                    complete: function () {
                        if(showAll.checked == false){
                            fila.remove(); // Elimina la fila una vez que la animación ha terminado
                        }
                        
                    }
                
                });
                
            contenedorTabla.style.overflowX = 'hidden';
        }
    };
    var data = 'id=' + id + '&id_usuario=' + id_usuario + '&id_estado=' + id_estado;
    console.log(data);
    xhr.send(data);


    }

</script>
</body>

</html>