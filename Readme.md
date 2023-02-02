

## Estudiantes CRUD
### Create
Para poder crear o insertar registros a la base de datos se hace uso de un formulario, el cuál se abre al momento de dar clic en el botón que tiene la leyenda "Nuevo registro". El funcionamiento de este botón es que redirecciona a otra vista que tiene dicho formulario, para esto se utiliza la función `create` que se encuentra en el controlador estudiantes y dentro de esta función se llama a la función `render` (el cuál se encuentra en la clase `View` pero en la clase `Controller` se hace una instancia en el constructor y como la clase `Estudiantes` extiende de `Controller` puede utilizar dicha función) y se le envía como parámetro la vista a renderizar.

En este caso se esta simulando o manejando los datos de un estudiante. Como se observa se solicitan los siguientes datos:
* Matricula.
* Nombre.
* Apellido paterno.
* Apellido materno.

Además, en la vista se pueden observar 2 botones, para guardar y regresar. Básicamente el botón para guardar lo que hace es que al momento de enviar los datos, los envia a una función ajax llamada `insertarDatos`, dentro de la función se especifíca que será una petición de tipo POST, que se va a enviar al método `registrar` que esta dentro de la clase `Estudiantes` el cuál tiene la funcionalidad de un controlador y también se envian los datos de los inputs. Luego, en la función registrar del controlador Estudiantes se hace una validación donde se verifica que los campos no esten vacios. 
* Si están vacios se envía a la función ajax un cero y se hace un return para que se salga de la función y así mismo en la función ajax muestre un mensaje de alerta con la librería `swal` en donde indique que los campos no pueden estar vacíos. 
* Si no están vacios se guardan dentro de un array llamado `datos`, para que se puedan enviar al modelo `EstudiantesModel`, especifícamente en la función `registrarDatos` y también se recibe como parámetro el array. Dentro de la función se hace uso de `Try catch` y se usa una consulta preparada para insertar los datos a la DB. Si todo esto esta correcto se hace return de la consulta que devuelve un 1, este resultado se envía a la función ajax para que nos pueda mostrar un mensaje que se ha guardado el registro. En dado caso que la matricula este repetida se mostrará otro mensaje indicando que no se pueden agregar campos repetidos.

Y finalmente el boton regresar, regresa a la vista principal del apartado de estudiantes.

## Read
Para leer o mostrar los datos se hace uso de una tabla la cuál se encuentra en la vista principal del apartado de estudiantes. 

Dentro del controlador estudiantes se tiene una función llamada `index`, en donde se manda a llamar a la función `getEstudiantes` que se encuentra en `EstudiantesModel` el cuál hace una consulta a la DB para obtener todos los registros de los estudiantes, esto también con la ayuda del método `fetchAll` el cual devuelve un array que contiene tadas las filas restantes del conjunto de resultados. Se hace un return para que en la función `index` se guarde en la variable `estudiantes` y esta variable se manda a la vista, para que de esta forma se pueda hacer un `foreach` y se pueda rellenar la tabla con los datos. Por último, en la función `index` se manda a llamar a la función `render` que permite renderizar la vista index.

Además de mostrar los registros en la tabla, también se muestra los botones para editar y eliminar respectivamente para cada registro.
* El botón editar redirecciona a otra página o vista.
* El botón eliminar, elimina el registro seleccionado.

## Updated
Para actualizar o editar un registro se debe de dar clic en el botón editar, al momento de dar clic redirecciona a otra vista, también se envía como parámetro la matricula a través de la url. La función `detail` la recibe y la guarda en una variable llamada `idMatricula`, luego se llama a la función `getByMatricula` que se encuentra en `estudiantesModel` y se le pasa como parámetro `idMatricula`. Se recibe la matricula del estudiante y con ello se hace una consulta para extraer el registro de la DB, y con el método `fetch` se guarda en un arreglo para ser guardados o asignados en la variable `estudiante` de la función `detail`. Luego se hace uso de la condición `if`, en donde si la consulta no regresa nada se hace uso de `header location` el cual redirecciona a la pagina de errores pero si la consulta regresa datos a continuación se crea una variable de sesión de llamada `alumno_Matricula`, esto con el fin que la matricula no se pueda cambiar (más adelante se explicará), en la variable de sesión se almacena la matricula extraída de la consulta.

¿Por que se almacena la matricula extraída de la consulta y no la que se envio a través de la url? Porque puede que la matricula enviada a través de la url no exista, así que primero se verifica haciendo la consulta.

Luego se envía a la vista el array que tiene los datos del estudiante y también se utiliza el método `render` para mostrar una nueva vista `edit`. Esta vista contiene un formulario y en los inputs se muestran los datos del estudiante con el array antes enviado. Para acceder al array y que se muestres los datos se hace uso de la siguiente sintaxis `<?php echo $this->estudiante[elemento];?>`. 

Al momento de dar clic en el botón "guardar", se envian los datos en la función ajax `actualizarDatos`, una vez se específica que será una petición de tipo `Post` y que los datos del formulario se enviarán en la función `actualizarDatos` que se encuentra en el controlador de estudiantes. Primero se valida que los campos enviados de los inputs no estén vacíos, si es así se hace un return y se muestra un mensaje que los campos no deben de estar vacíos.

Luego se utiliza la variable de sesión creada anteriormente. 
* Se creó la variable de sesión y se le asigno el valor de la matricula del estudiantes ya que es un dato que el usuario no debe de modificar y a pesar que lo haga no se utiliza la matricula enviada a través del formulario. 

Una vez que se valido que los campos no están vacíos se guardan en un array `datos` y se elimina la variable de sesión. Luego se llama a la función `updateEmpleado` que se encuentra en `estudiantesModel` y se le envía el array `datos`.

Dentro de la función `updateEmpleado` se hace la consulta correspondiente para actualizar datos. Si todo esta correcto se mostrará un cuadro de diálogo con el mensjae de "Dato actualizado con éxito" y después de dar clic en el botón "Ok" redireccionará a la página principal de estudiantes. Y si hay un error en la consulta mostrará el error.

## Delete
En el caso de eliminar un registro, al momento de dar clic en el icono se activará la función ajax `eliminarDatos`, el cuál recibe como parámetro la matricula del estudiante. Luego se envía a la función `delete` que se encuentra en el controlador de estudiantes. Dentro de la función se recibe la matricula y se guardar en la variable `matricula`, luego se llama a la función `deleteEstudiante` y se envía la variable, para así hacer su respectiva consulta a la DB y eliminar el registro. 
Al final, si todo esta correcto en la función ajax con un poco de JS se elimina la fila y así mismo se muestra un mensaje de "Eliminado con éxito". Si hubiera algún error se muestra un mensaje de error.







***NOTAS***
Si se puede usar una variable de sesión al momento de actualizar, esto con el fin que un dato no se cambie como en el caso de la matricula. El problema era que después de actualizar los datos no se redireccionaba a otra página, así que al momento de querer actualizar los datos la página se rompía porque la variable de sesión se eliminaba y para volver a guardar una variable de sesión se tenía que enviar a través de la URL, luego hacer la consulta para saber si existe y si todo esta bien se guarda en la variable de sesión.

Así que la solución fue que después de actualizar los datos era redireccionar a otra vista, en este caso a la vista principal de estudiantes.