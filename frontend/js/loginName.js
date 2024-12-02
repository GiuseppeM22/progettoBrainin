const { createApp } = Vue;

createApp({
    data() {
        return {
            loginUserName: '',
        };
    },
    mounted() {
        //chiamata per controllare lo stato di login
        axios.get('http://127.0.0.1:8888/progettoBrainin/backend/controller/controller.dashboard.php', {
            withCredentials: true 
        })
            .then(response => {
                if (response.data.success) {
                    this.loginUserName = response.data.name;
                } else {
                    // se l'utente non risulta loggato reindirizzo a login
                    console.log(JSON.stringify(response.data) + 'sono nell else');
                    window.location.href = '../html/login.html';
                }
            })
            .catch(error => {
                console.error('Errore durante il controllo login:', error);
                window.location.href = '../html/login.html';  
            });
    },
    methods:{
        //chiamata per effettuare il logout
        logout(){
            axios.get('http://127.0.0.1:8888/progettoBrainin/backend/controller/controller.logout.php', {
                withCredentials: true 
            })
            .then(response => {
                // Dopo il logout, reindirizza alla pagina di login
                window.location.href = '../html/login.html';
            })
            .catch(error => {
                console.error('Errore durante il logout:', error);
            });
            
    }
}
}).mount('#app');