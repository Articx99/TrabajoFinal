</div>
</div>

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/popper.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/anime.min.js"></script>
<script>

    document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var estado = checkbox.checked;
            console.log(checkbox.checked);
            if (checkbox.id != 'showAll') {
                if (estado) {
                    completeTask(this.dataset.id, this.dataset.id_etiqueta, estado);
                }
                else {
                    completeTask(this.dataset.id, this.dataset.id_etiqueta, estado);
                }
            }



        });
    });

    var checkboxes = document.querySelectorAll('input[type="checkbox"][data-etiqueta]');
    for (var i = 0; i < checkboxes.length; i++) {
        var checkbox = checkboxes[i];
        var etiqueta = checkbox.dataset.etiqueta;

        checkbox.addEventListener('change', function () {
            value = checkbox.checked;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/getCompleted', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                    location.reload();
                }
            };

            xhr.send('showAll=' + value + '&etiqueta=' + etiqueta);
        });
    }

    function deleteItem(id, url, id_etiqueta = 0) {
        var fila = document.querySelector(`.id${id}`);
        if (url == "deleteUser" && id == <?php echo $_SESSION['id'] ?>) {
            anime({
                targets: fila,
                translateY: [
                    { value: '-5px', duration: 50 },
                    { value: '5px', duration: 50 },
                    { value: '0px', duration: 150 },
                ],
                scaleY: [
                    { value: 1.4, duration: 150 },
                    { value: 0.6, duration: 150 },
                    { value: 1, duration: 150 },
                ],
                backgroundColor: '#ff0000',
                easing: 'easeInOutQuad',
                duration: 200,
                loop: 2, // Repetir la animación dos veces
                direction: 'alternate', // Invertir la dirección de la animación cada vez que se repite
                complete: function () {
                    fila.style.transform = ''; // Vuelve a su estado original
                    fila.style.backgroundColor = ''; // Vuelve a su color de fondo original
                    var tbl = document.querySelector(`#tb${id_etiqueta}`);
                    var div = document.querySelector(`#div${id_etiqueta}`);
                    if (tbl !== null && tbl.rows.length == 1) {
                        div.style.display = 'none';
                    }
                }
            });

        }
        else {
            console.log(url);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', `/${url}`, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                    anime({
                        targets: fila,
                        opacity: 0,
                        translateY: '50px',
                        backgroundColor: '#ff0000',
                        easing: 'easeInOutQuad',
                        duration: 1000,
                        complete: function () {
                            fila.remove(); // Elimina la fila una vez que la animación ha terminado
                            var tbl = document.querySelector(`#tb${id_etiqueta}`);
                            var div = document.querySelector(`#div${id_etiqueta}`);
                            if (tbl !== null && tbl.rows.length == 1) {
                                div.style.display = 'none';
                            }
                        }
                    });

                }
            };
            var data = 'id=' + id;
            xhr.send(data);

        }
    }

    function completeTask(id, id_etiqueta, estado) {
        var xhr = new XMLHttpRequest();
        var id_estado = estado ? '2' : '1';

        console.log(id_estado);
        xhr.open('POST', '/complete', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                var showAll = document.getElementById("showAll" + id_etiqueta);

                var contenedorTabla = document.querySelector("#content");
                var fila = document.querySelector('.id' + id);
                const animation = anime({
                    targets: fila,
                    translateX: '130%',
                    duration: 1500,
                    direction: showAll.checked ? 'alternate' : 'normal',
                    backgroundColor: '#90EE90',
                    easing: 'easeInOutSine',

                    complete: function () {
                        if (showAll.checked == false) {
                            fila.remove(); // Elimina la fila una vez que la animación ha terminado
                            
                            var tbl = document.querySelector(`#tb${id_etiqueta}`);
                            var div = document.querySelector(`#div${id_etiqueta}`);
                            if (tbl !== null && tbl.rows.length == 1) {
                                div.style.display = 'none';
                            }
                        }

                    }

                });
                contenedorTabla.style.overflowX = 'hidden';
            }
        };
        var data = `id=${id}&id_estado=${id_estado}`;

        xhr.send(data);


    }



</script>
</body>

</html>