</div>
</div>

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/popper.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/anime.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.3/particles.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.0/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/confetti-js"></script>
<script>

    document.querySelectorAll('input[type=checkbox]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            var estado = checkbox.checked;

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
        const fila = document.querySelector(`.id${id}`);
        const tbl = document.querySelector(`#tb${id_etiqueta}`);
        const subDiv = document.querySelector(`#subDiv${id_etiqueta}`);

        if (url === "deleteUser" && id === <?php echo $_SESSION['id'] ?>) {
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
                loop: 2,
                direction: 'alternate',
                complete: () => {
                    fila.style.transform = '';
                    fila.style.backgroundColor = '';
                    if (tbl !== null && tbl.rows.length === 1) {
                        subDiv.style.display = 'none';
                    }
                    
                }
            });

        } else {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', `/${url}`, true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = () => {
                if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                    if(url == "deleteEtiqueta" && id_etiqueta === 0){
                        
                        location.reload();
                    }
                    
                    anime({
                        targets: fila,
                        opacity: 0,
                        translateY: '50px',
                        backgroundColor: '#ff0000',
                        easing: 'easeInOutQuad',
                        duration: 800,
                        complete: () => {
                            fila.remove();
                            if (tbl !== null && tbl.rows.length === 1) {
                                subDiv.style.display = 'none';
                            }
                           
                        }
                    });
                    
                }
            };
            xhr.send(`id=${id}`);
            
        }
    }

    function completeTask(id, id_etiqueta, estado) {
        var xhr = new XMLHttpRequest();
        var id_estado = estado ? '2' : '1';

        xhr.open('POST', '/complete', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                var showAll = document.getElementById("showAll" + id_etiqueta);

                var contenedorTabla = document.querySelector("#content");
                var fila = document.querySelector('.id' + id);
                var tbl = document.querySelector(`#tb${id_etiqueta}`);
                var mainDiv = document.querySelector(`#mainDiv${id_etiqueta}`);
                var subDiv = document.querySelector(`#subDiv${id_etiqueta}`);

                const animation = anime({
                    targets: fila,
                    translateX: '130%',
                    duration: 1500,
                    direction: showAll.checked ? 'alternate' : 'normal',
                    backgroundColor: '#90EE90',
                    easing: 'easeInOutSine',
                    complete: function () {
                        fila.remove(); // Elimina la fila una vez que la animación ha terminado                         
                        if (tbl !== null && tbl.rows.length == 1) {
                            subDiv.style.display = 'none';

                            const confettiContainer = document.createElement('canvas');
                            confettiContainer.style.width = '100%';
                            confettiContainer.style.height = 'auto';
                            confettiContainer.id = 'celebration-container';
                            mainDiv.appendChild(confettiContainer);

                            // Agregar la animación de confeti al elemento de celebración
                            const confettiSettings = { target: 'celebration-container', max: 80 };
                            const confetti = new ConfettiGenerator(confettiSettings);
                            confetti.render();

                            // Mostrar el cuadro de diálogo después de 5 segundos y eliminar la animación de confeti y el elemento de celebración
                            setTimeout(() => {
                                const messageContainer = document.createElement('div');
                                messageContainer.innerHTML = "¡Has completado todas las tareas, felicidades! ¿Deseas eliminar la etiqueta?";
                                messageContainer.id = 'dialog';
                                const body = document.body;
                                body.classList.add('blur');
                                mainDiv.appendChild(messageContainer);
                                const buttonStyles = {
                                    border: 'none',
                                    padding: '10px 20px',
                                    borderRadius: '5px',
                                    margin: '5px',
                                    fontWeight: 'bold',
                                    cursor: 'pointer',
                                    transition: 'all 0.2s ease-in-out',
                                    boxShadow: '0px 5px 15px rgba(0,0,0,0.1)'
                                };

                                // Estilos para el botón 'Sí'
                                const yesButtonStyles = {
                                    ...buttonStyles,
                                    background: '#205500',
                                    color: '#fff'
                                };

                                // Estilos para el botón 'No'
                                const noButtonStyles = {
                                    ...buttonStyles,
                                    background: '#f44336',
                                    color: '#fff'
                                };

                                // Crear los botones
                                const yesButton = document.createElement('button');
                                yesButton.innerText = 'Sí';
                                Object.assign(yesButton.style, yesButtonStyles);

                                const noButton = document.createElement('button');
                                noButton.innerText = 'No';
                                Object.assign(noButton.style, noButtonStyles);

                                yesButton.addEventListener('click', () => {
                                    // Aquí podrías llamar a una función que elimine la etiqueta
                                    messageContainer.style.display = 'none';
                                    messageContainer.remove();
                                    mainDiv.style.display = 'none';
                                    body.classList.remove('blur');
                                    deleteItem(id_etiqueta, "deleteEtiqueta");
                                    location.reload();
                                    
                                });
                                messageContainer.appendChild(yesButton);
                            

                                noButton.addEventListener('click', () => {
                                    messageContainer.style.display = 'none';
                                    confetti.clear();
                                    confettiContainer.style.display = 'none';
                                    messageContainer.remove();
                                    body.classList.remove('blur');
                                    mainDiv.style.display = 'none';
                                });
                                messageContainer.appendChild(noButton);

                                confetti.clear();
                                confettiContainer.remove();
                            }, 2000);
                        }
                    }
                });
            }

        }

        var data = `id=${id}&id_estado=${id_estado}`;

        xhr.send(data);


    }



</script>
</body>

</html>