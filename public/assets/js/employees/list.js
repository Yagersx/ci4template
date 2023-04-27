const base_url = window.location.href;
let isAdmin = false;
let searchTimeout = null;

jQuery(function () {
    const dataTable = $('#employees-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        searchDelay: 1000,
        ajax: {
            url: base_url + '/datatable',
            type: 'GET',
            dataSrc: function (response) {
                // Dado que el servidor devuelve un objeto con la propiedad data y este contiene dos valores
                // isAdmin y employees, se extraen los valores y se asignan a las variables globales

                isAdmin = response.data.isAdmin;
                return response.data.employees;
            },
        },
        columns: [
            { data: 'name' },
            { data: 'last_name' },
            { data: 'birthday' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'address' },
            { data: 'salary' },
            { data: 'description' },
            {
                data: 'employee_id', render: function (data, type, row, meta) {
                    //Dado que el dibujado se hace por secciones de 10 en 10, 
                    //se utiliza el render de la columna para dibujar los botones

                    //data es el valor de la columna, en este caso el id del empleado
                    return isAdmin ? `
                        <a href="${base_url}/edit/${data}" class="btn btn-primary">Editar</a>
                        <a href="${base_url}/delete/${data}" class="btn btn-danger delete-btn">Eliminar</a>
                    ` : '-';
                }
            },
        ],
        drawCallback: function (settings) {
            // Dibujar botones de eliminación
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', event => {
                    event.preventDefault();

                    const url = event.target.getAttribute('href');

                    // Mostrar el sweetalert y confirmar la eliminación
                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "Esta acción no se puede deshacer",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Si, borrar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    })
                });
            });
        }
    });
});
