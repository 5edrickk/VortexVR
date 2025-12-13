
/*Mise en place des Fonctionnalité Java Script 
Pour la page Checkout*/

if (document.URL.includes("checkout.php")) {

    let buttons = document.querySelectorAll(".qty-btn");

    for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", gererQuantity);
    }

  function gererQuantity(e) {
    let btn = e.target;
    let card = btn.closest(".checkout-product-card");

    let qteEl = card.querySelector(".product-quantity");
    let qte = lireQteDepuisTexte(qteEl.textContent);

    if (btn.textContent.includes("+")){
        qte++;
    } 
    if (btn.textContent.includes("-") && qte > 1){
        qte--;
    } 

    ecrireQte(qteEl, qte);

    recalculerRecap();
    sauverQtesParProduit();
  }

  document.querySelector(".checkout-action").addEventListener("submit", validerPanier);
  
  function validerPanier(e){
    recalculerRecap();
    sauverQtesParProduit();

    let valider = confirm("Voulez-vous confirmer la validation de votre panier ?");

    if (!valider){
         e.preventDefault();
    }
  };

  function round2(n) {
    return Math.round(n * 100) / 100;
  }

  function lireMontant(txt) {
    return parseFloat(txt.replace("$", "").replace(/\s/g, "").replace(",", ".")) || 0;
  }

  function ecrireMontant(n) {
    return n.toLocaleString("fr-CA", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  function lireQteDepuisTexte(txt) {
    let match = txt.match(/(\d+)\s*$/);
    return match ? parseInt(match[1], 10) : 1;
  }

  function ecrireQte(el, qte) {
    el.textContent = "Quantité dans le panier : " + qte;
  }

  let rows = document.querySelectorAll(".checkout-breakdown-box .breakdown-row");

  let nbEl = rows[0].querySelector(".breakdown-value");        
  let montantEl = rows[1].querySelector(".breakdown-value");  
  let livraisonEl = rows[2].querySelector(".breakdown-value"); 
  let tpsEl = rows[3].querySelector(".breakdown-value");       
  let tvqEl = rows[4].querySelector(".breakdown-value");       
  let totalEl = rows[5].querySelector(".breakdown-value");     

  function recalculerRecap() {
    let cards = document.querySelectorAll(".checkout-product-card");

    let nbArticles = 0;
    let montantArticles = 0;

    for (let i = 0; i < cards.length; i++) {
      let qteEl = cards[i].querySelector(".product-quantity");
      let prixEl = cards[i].querySelector(".product-price");

      let qte = lireQteDepuisTexte(qteEl.textContent);
      let prix = lireMontant(prixEl.textContent);

      nbArticles += qte;
      montantArticles += qte * prix;
    }

    montantArticles = round2(montantArticles);

    let livraison = lireMontant(livraisonEl.textContent);
    let tps = round2(montantArticles * 0.05);
    let tvq = round2(montantArticles * 0.09975);
    let totalFinal = round2(montantArticles + livraison + tps + tvq);

    nbEl.textContent = nbArticles;
    montantEl.textContent = ecrireMontant(montantArticles) + " $";
    tpsEl.textContent = ecrireMontant(tps) + " $";
    tvqEl.textContent = ecrireMontant(tvq) + " $";
    totalEl.textContent = ecrireMontant(totalFinal) + " $";

    setCookie("checkout_qte", nbArticles, 1);
    setCookie("checkout_total", totalFinal.toFixed(2), 1);
  }

  function sauverQtesParProduit() {
    let cards = document.querySelectorAll(".checkout-product-card");
    let map = {};

    for (let i = 0; i < cards.length; i++) {
      let nom = cards[i].querySelector(".product-name").textContent.trim();
      let qteEl = cards[i].querySelector(".product-quantity");
      map[nom] = lireQteDepuisTexte(qteEl.textContent);
    }

    setCookie("checkout_qtes", JSON.stringify(map), 1);
  }

  function restaurerQtesParProduit() {
    let raw = getCookie("checkout_qtes");
    let map = JSON.parse(raw);
    let cards = document.querySelectorAll(".checkout-product-card");

    for (let i = 0; i < cards.length; i++) {
      let nom = cards[i].querySelector(".product-name").textContent.trim();
      if (map[nom] != null) {
        let qteEl = cards[i].querySelector(".product-quantity");
        ecrireQte(qteEl, parseInt(map[nom], 10));
      }
    }
  }

  restaurerQtesParProduit();
  recalculerRecap();
  sauverQtesParProduit();

}

/*Mise en place des Fonctionnalité Java Script 
Pour la page Wallet*/

if (document.URL.includes("wallet.php")) {
    let qteCookie = getCookie("checkout_qte");
    let totalCookie = getCookie("checkout_total");

    let rows = document.querySelectorAll(".wallet-row");

    let qteSpan = rows[1].querySelector("span:last-child");

    let totalSpan = document.querySelector(".wallet-total span:last-child");

    if (qteCookie !== "") {
        qteSpan.textContent = qteCookie;
    }

    if (totalCookie !== "") {
        let total = parseFloat(totalCookie).toFixed(2);
        totalSpan.textContent = total.replace(".", ",") + " $";
    }

    let formAchat = document.querySelector(".wallet-actions form");

    formAchat.addEventListener("submit", confirmerAchat); 
    
    function confirmerAchat (e) {
        let ok = confirm("Confirmer la validation de l'achat ?");
        if (!ok) {
            e.preventDefault();
            return;
        }
    };
}


 function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

  function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }