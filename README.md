# WEB2_Entrega3
Tercer entrega del TPE de WEB 2

## Integrantes
1. Añon, Luciano DNI: 45543333 Email: lucianoanon@gmail.com
2. López Cáceres, María Lucía DNI: 46555036 Email: mlopezcaceres@alumnos.exa.unicen.edu.ar

## EndPoints
### GET
1. (nombre del proyecto)/api/libros 
    - Para ordenar: 
        - Por parámetro: ?orderBy=(parámetro) parámetro=id||id_autor||titulo||genero||paginas
        - Ascendiente o Descendiente: &forma=asc||desc
        - Para poder ordenar de forma ascendiente o descendiente se debe tener orderBy,
            de lo contrario se ordenará ascendientemente por default.
### PUT
1. (nombre del proyecto)/api/libros/:id 
    - Escriba en el body del request todos los campos con los valores a editar. 
    - De faltar un campo tendrá un error.
    - De no existir el libro que se quiere editar o el autor al que se quiere asignar el libro tendrá un error.
