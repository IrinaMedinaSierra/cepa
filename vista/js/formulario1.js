window.onload=function () {
    let fechaNacimiento=document.querySelector("#fNacimiento");
    let hoy=new Date(); //2024-10-24
    let year=hoy.getFullYear(); //2024
    let fechaMin=year-18;
    let mesMin=String(hoy.getMonth()+1).padStart(2,"0");//para meses que sean del 1 al 9 ponga 0 delante
    let diaMin=String(hoy.getDate()).padStart(2,"0");
    //este funcion tiene que pasarle como atributo min al input para que no permita fechas mayores
    let fechaFormulario=fechaMin+"-"+mesMin+"-"+diaMin;
    fechaNacimiento.setAttribute("max",fechaFormulario);
}