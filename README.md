# Software developer test
Una prueba para unirse al equipo de desarrollo de Euromillions.com

## Como empezar

Necesitas tener docker, docker-compose y PHP7 instalado en tu entorno.

Haz un clone del proyecto y lanza el fichero bootstrap.sh(entendemos que trabajas con Linux, Mac, BSD). Si tienes
windows ponte en contacto con nosotros.

Que hace el fichero bootstrap.sh ?

Descarga dos imágenes docker y arranca dos contenedores, mysql y phpunit, que mediante un alias podrás llamarlo desde 
la línea de comandos y así ejecutar los tests.
 
Si necesitas alguna aclaración o encuentras algún error, escribe una issue en el repositorio. 

## Que hay que hacer

Como tenemos muchas integraciones con diferentes Apis, el test estará relacionado con estas.

Queremos recuperar los resultados del último sorteo de Euromillions. Para esto necesitarás
invocar a una API.

#####Por favor, cuando inicies la prueba, te pones en contacto con nosotros y te envíamos el endpoint y api key necesaria para tener acceso. 

Tienes que diseñar sabiendo que esta api puede fallar en algún momento y necesitamos poder invocar a otra API para recuperar los
resultados(esta segunda API que implementes puede ser un fake).

El último resultado se visualiza en la home y recibimos muchas visitas(evita consultar a la bbdd para mostrar el resultado).

Este último resultado lo mostrarás por el terminal cuando invoquemos el script de inicio.

Puedes utilizar cualquier patrón de diseño que necesites, VO y sobretodo, test unitarios y de integración.

## Dudas

Puedes abrir una issue en este repositorio.

## Como enviar tu solución

Haz un pull request al repositorio o nos la envías por email. 