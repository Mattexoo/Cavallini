function cambiaCartaHome(){
    switch (document.getElementById("sceltaSeme").value){
        case "h":
            document.getElementById("imgSemeHome").src="./ImmaginiCarte/bg_h1.gif";
            break;
        case "d":
            document.getElementById("imgSemeHome").src="./ImmaginiCarte/bg_d1.gif";
            break;
        case "c":
            document.getElementById("imgSemeHome").src="./ImmaginiCarte/bg_c1.gif";
            break;
        case "s":
            document.getElementById("imgSemeHome").src="./ImmaginiCarte/bg_s1.gif";
            break;
    }
}
