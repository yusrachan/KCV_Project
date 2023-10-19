Pour mon projet, je souhaite faire un site sur une entreprise de kinésithérapie et les patients peuvent prendre un rendez-vous via un calendrier. Dans celui-ci, on peut voir quelle date le kinésithérapeute est disponible.
Lorsque le client clique sur une date, une fenêtre s'ouvre et il doit entrer ses coordonnées.
Quand il valide le formulaire, un mail est envoyé au kinésithérapeute pour lui avertir qu'il aura une séance à la date choisie par le client.


eventClick: function (info){
      console.log (info.event.id);
      let idEvenementEffacer = info.event.id;
      // on doit effacer de la BD aussi!
      axios.post("/effacer/evenement", 
       { id: idEvenementEffacer})
      .then (function (response){
        // si success dans l'insertion dans la BD
        console.log (response);
        // effacer du calendrier (interface)  
        calendar.getEventById(idEvenementEffacer).remove();
    });
}

faire fixture many to many entre tranchehoraire et disponibilite dans tranchehorairedispo