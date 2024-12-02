
const { createApp } = Vue

createApp({
    data() {
        return {
            loading: false,
            email: '',
            password: '',
            passwordVisible: false,
            formSubmitted: false,
            emailPresent: '',
            successRegistration: '',
            successLogin:'',
            failureLogin:'',
            passwordError: '',
            loginUserName:'',
            formData: {
                name: '',
                surname: '',
                email: '',
                phone: '',
                password: '',
                confirmPassword: '',
                termsAccepted: false
            },
            loginForm: {
                email: '',
                password: '',
            },
            passwordMismatch: false,
        }
    },
    methods: {
        // metodo di validazione della password
        validatePassword(password) {
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&£])[A-Za-z\d@$!%*?&]{8,}$/;
            return passwordRegex.test(password);
        },
        //al click del tasto login o register setto loading a true
        activeteLoading() {
            this.loading = true;
        },
        //metodo per rendere visibile la password
        togglePassword() {
            this.passwordVisible = !this.passwordVisible
        },
        //invio dati registrazione utente al back
        registerUser() {
            // Reset errore password
            this.passwordError = "";

            // Controllo se la password è valida
            if (!this.validatePassword(this.formData.password)) {
                this.passwordError = "La password deve contenere almeno 8 caratteri, un carattere maiuscolo, un carattere minuscolo, un numero e un simbolo.";
                return;
            }

            this.formSubmitted = true

            if (this.formData.password == this.formData.confirmPassword && this.formData.termsAccepted) {
                const formData = {
                    name: this.formData.name,
                    surname: this.formData.surname,
                    email: this.formData.email,
                    phone: this.formData.phone,
                    password: this.formData.password
                };
                console.log(formData);

                /*************************** REGISTRAZIONE UTENTE **************************/

                axios.post('http://localhost:8888/progettoBrainin/backend/controller/controller.register.php', formData)
                    .then(response => {
                        console.log(response);
                        
                        // Controllo se la risposta contiene un messaggio
                        if (response.data && response.data.message) {
                            this.loading = true
                            console.log('Risposta dal backend:', response.data);
                            this.successRegistration = response.data.message;
                            //se ha successo la registrazione reindirizzo alla pagina di login
                            setTimeout(() => {
                                this.loading = true
                                window.location.href = '../html/login.html';
                            }, 3000);

                            
                        } else {
                            console.log('Registrazione completata ma nessun messaggio trovato nella risposta.');
                            
                        }
                    })
                    .catch(error => {
                        if (error.response) {
                            // Errore gestito dal backend
                            console.error('Errore dal backend:', error.response);
                            const backendMessage = error.response.data && error.response.data.message
                                ? error.response.data.message
                                : 'Errore sconosciuto dal backend.';
                            this.emailPresent = backendMessage;
                        } else if (error.request) {
                            // Nessuna risposta ricevuta dal server
                            console.error('Nessuna risposta dal server:', error.request);
                            alert('Nessuna risposta dal server. Riprova più tardi.');
                        } else {
                            // Errore nella configurazione della richiesta
                            console.error('Errore durante la configurazione della richiesta:', error.message);
                            alert('Si è verificato un errore imprevisto. Riprova.');
                        }
                    })
                    .finally(() => {
                        console.log('Richiesta completata.');
                    });
            }

        },
        handleLogin() {
            this.loading = true; 
            const loginForm = {
                email: this.loginForm.email,
                password: this.loginForm.password
            };

            /*************************** LOGIN **************************/

            axios.post('http://127.0.0.1:8888/progettoBrainin/backend/controller/controller.login.php', loginForm,{
                withCredentials: true 
            }) 
                .then(response => {
                    // Controllo se la risposta contiene un messaggio
                    if (response.data && response.data.message) {
                        console.log(this.loginForm);
                        console.log('Risposta dal backend:', response.data);
                        console.log(response.data);
                        if (response.data.success) {
                            this.successLogin = response.data.message;
                            this.loginUserName = response.data.name
                            //se ha successo la login reindirizzo alla pagina di login
                            setTimeout(() => {
                                window.location.href = `../html/dashboard.html`;
                            }, 2000);
                        } else {
                            this.failureLogin = response.data.message;
                        }
                    } else {
                        console.log('Registrazione completata ma nessun messaggio trovato nella risposta.');
                    }
                })
                .catch(error => {
                    if (error.response) {
                        // Errore gestito dal backend
                        console.error('Errore dal backend:', error.response);

                        const backendMessage = error.response.data && error.response.data.message
                            ? error.response.data.message
                            : 'Errore sconosciuto dal backend.';
                        this.emailPresent = backendMessage;
                    } else if (error.request) {
                        // Nessuna risposta ricevuta dal server
                        console.error('Nessuna risposta dal server:', error.request);
                        alert('Nessuna risposta dal server. Riprova più tardi.');
                    } else {
                        // Errore nella configurazione della richiesta
                        console.error('Errore durante la configurazione della richiesta:', error.message);
                        alert('Si è verificato un errore imprevisto. Riprova.');
                    }
                })
                .finally(() => {
                    console.log('Richiesta completata.');
                });
        }
    }
}).mount('#app')