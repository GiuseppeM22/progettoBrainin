Guida per l'Avvio del Progetto

Requisiti

Front-End:
Per il corretto funzionamento del progetto, si consiglia di avviare il front-end su un server. Per semplificare il processo, si suggerisce l'uso dell'estensione Live Server di Visual Studio Code.

Backend:
Server Apache configurato sulla porta: 8888.
I parametri di configurazione per il database sono contenuti nel file backend/model/Database.php.

Librerie Utilizzate
Le seguenti librerie sono utilizzate nel progetto:

Axios: Per la gestione delle richieste HTTP. Non è necessario installarla manualmente, in quanto è già inclusa tramite CDN.
FontAwesome: Per le icone. Anche questa libreria è già importata tramite CDN.
Vue.js: Vue è importato direttamente tramite CDN, quindi non è necessaria una configurazione aggiuntiva per l'installazione.

Istruzioni per l'Avvio del Front-End

Installazione di Live Server:
Scarica e installa l'estensione Live Server per Visual Studio Code.
Una volta installata, apri il file register.html nel tuo editor.
In basso a destra, dovrebbe apparire la scritta Go Live.
Clicca su Go Live per avviare il server di sviluppo e visualizzare il front-end nel browser.
Nota: Anche se Live Server non supporta direttamente la gestione delle politiche CORS, il backend è stato configurato per gestirle correttamente.

Integrazione Front-End e Back-End
Una volta avviato il server del front-end utilizzando Live Server, i file del backend (come controller.login.php, controller.dashboard.php, controller.logout.php) risponderanno strettamente alle politiche CORS su http://127.0.0.1:5500.

Se il tuo progetto front-end viene eseguito su un dominio o una porta diversa, sarà necessario aggiornare i riferimenti solo nei file citati sopra
