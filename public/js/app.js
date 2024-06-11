function addEventListeners() {


    let itemCheckers = document.querySelectorAll('article.card li.item input[type=checkbox]');
    [].forEach.call(itemCheckers, function(checker) {
      checker.addEventListener('change', sendItemUpdateRequest);
    });
  
    let itemCreators = document.querySelectorAll('article.card form.new_item');
    [].forEach.call(itemCreators, function(creator) {
      creator.addEventListener('submit', sendCreateItemRequest);
    });

    //adicionado para adicionar uma resposta
    let answersCreators = document.querySelectorAll('article.question form.new_answer');
  [].forEach.call(answersCreators, function(creator) {
    creator.addEventListener('submit', sendCreateAnswerRequest);
  });

  
    let itemDeleters = document.querySelectorAll('article.card li a.delete');
    [].forEach.call(itemDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteItemRequest);
    });
  
    let cardDeleters = document.querySelectorAll('article.card header a.delete');
    [].forEach.call(cardDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteCardRequest);
    });
  
    let cardCreator = document.querySelector('article.card form.new_card');
    if (cardCreator != null)
      cardCreator.addEventListener('submit', sendCreateCardRequest);

      //Adicionei isto para a pesquisa de cards


      var currentPath = window.location.pathname;

    //--------------------------------------------------------------------------
    if(currentPath == '/cards') {
    var searchForm = document.getElementById('searchForm');
    searchForm.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent the default form submission

      // Get the search query from the input field
      var searchQuery = document.getElementById('search').value;

      // ao mudar para este link, a página é recarregada com o resultado da pesquisa
      // a api é chamada e o resultado é mostrado
      window.location.href = '/cards' + '?search=' + searchQuery; 
  });
}
    //--------------------------------------------------------------------------
    if( currentPath == '/questions') {
    var searchFormQuestions = document.getElementById('searchQuestionsForm');
    searchFormQuestions.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent the default form submission

      // Get the search query from the input field
      var searchQuery = document.getElementById('searchQuestions').value;

      // ao mudar para este link, a página é recarregada com o resultado da pesquisa
      // a api é chamada e o resultado é mostrado
      window.location.href = '/questions' + '?search=' + searchQuery; 
  });

  }
  // Adicionei isto para a criação de uma pergunta

  var createQuestionsForm = document.getElementById('createQuestionsForm');
  createQuestionsForm.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent the default form submission
  
      // Get the values from the form
      var title = document.getElementById('questionTitle').value;
      var content = document.getElementById('questionContent').value;
  
      // Validate the form fields
      if (title.trim() === '' || content.trim() === '') {
          alert('Please fill in all fields.');
          return;
      }
  
      // Specify the URL for your AJAX request
      var apiUrl = '/api/questions/createQuestion';
  
      // Create a new question object
      var newQuestion = {
          title: title,
          content: content
      };
  
      // Use the sendAjaxRequest function to make a POST request
      sendAjaxRequest('POST', apiUrl, newQuestion, function () {
          // Handle the response when the request is complete
          if (this.status === 200) {
              // Successful response
              var responseData = JSON.parse(this.responseText);
  
              // Assuming responseData contains the newly created question data
              console.log('Response Data:', responseData);
  
              // Redirect to the page showing the newly created question

              //window.location.href = '/questions/' + responseData.questionId;
              window.location.href = '/questions' ;
          } else {
              // Error handling
              console.error('Error:', this.statusText);
              // Handle the error, e.g., show an error message to the user
          }
      });
  });
  
}
  
  function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }
  
  function sendAjaxRequest(method, url, data, handler) {

    console.log('Method:', method);
    console.log('URL:', url);
    console.log('Data:', data);

    let request = new XMLHttpRequest();
  
    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
  }
  
  function sendItemUpdateRequest() {
    let item = this.closest('li.item');
    let id = item.getAttribute('data-id');
    let checked = item.querySelector('input[type=checkbox]').checked;
  
    sendAjaxRequest('post', '/api/item/' + id, {done: checked}, itemUpdatedHandler);
  }
  
  function sendDeleteItemRequest() {
    let id = this.closest('li.item').getAttribute('data-id');
  
    sendAjaxRequest('delete', '/api/item/' + id, null, itemDeletedHandler);
  }
  
  function sendCreateItemRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
    let description = this.querySelector('input[name=description]').value;
  
    if (description != '')
      sendAjaxRequest('put', '/api/cards/' + id, {description: description}, itemAddedHandler);
  
    event.preventDefault();
  }
// Adicionei este método para enviar o pedido de criação de uma resposta
  function sendCreateAnswerRequest(event) {
    let questionId = this.closest('article').getAttribute('data-id');
    let content = this.querySelector('input[name=content]').value;
  
    if (content != '')
      sendAjaxRequest('put', '/api/questions/' + questionId, {content: content} ,answerAddedHandler);
  
    event.preventDefault();
  }

  
  function sendDeleteCardRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
  
    sendAjaxRequest('delete', '/api/cards/' + id, null, cardDeletedHandler);
  }
  
  function sendCreateCardRequest(event) {
    let name = this.querySelector('input[name=name]').value;
  
    if (name != '')
      sendAjaxRequest('put', '/api/cards/', {name: name}, cardAddedHandler);
  
    event.preventDefault();
  }
  
  function itemUpdatedHandler() {
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    let input = element.querySelector('input[type=checkbox]');
    element.checked = item.done == "true";
  }
  
  function itemAddedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
  
    // Create the new item
    let new_item = createItem(item);
  
    // Insert the new item
    let card = document.querySelector('article.card[data-id="' + item.card_id + '"]');
    let form = card.querySelector('form.new_item');
    form.previousElementSibling.append(new_item);
  
    // Reset the new item form
    form.querySelector('[type=text]').value="";
  }


   // Adicionei este método para adicionar uma resposta 
   function answerAddedHandler() {
    if (this.status != 200) window.location = '/questions';
    
    let responseData = JSON.parse(this.responseText);

// Access the properties from the parsed JSON and assign to variables
    let answer = responseData.answer;
    let user_name = responseData.user_name;
  
    // Create the new item
    let new_answer = createAnswer(answer , user_name);
  
    // Insert the new item
    let question = document.querySelector('article.question[data-id="' + answer.question_id + '"]');
    let form = question.querySelector('form.new_answer');
    form.previousElementSibling.append(new_answer);
  
    // Reset the new item form
    form.querySelector('[type=text]').value="";
  }

  function itemDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    element.remove();
  }
  
  function cardDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let card = JSON.parse(this.responseText);
    let article = document.querySelector('article.card[data-id="'+ card.id + '"]');
    article.remove();
  }
  
  function cardAddedHandler() {
    if (this.status != 200) window.location = '/';
    let card = JSON.parse(this.responseText);
  
    // Create the new card
    let new_card = createCard(card);
  
    // Reset the new card input
    let form = document.querySelector('article.card form.new_card');
    form.querySelector('[type=text]').value="";
  
    // Insert the new card
    let article = form.parentElement;
    let section = article.parentElement;
    section.insertBefore(new_card, article);
  
    // Focus on adding an item to the new card
    new_card.querySelector('[type=text]').focus();
  }
  
  function createCard(card) {
    let new_card = document.createElement('article');
    new_card.classList.add('card');
    new_card.setAttribute('data-id', card.id);
    new_card.innerHTML = `
  
    <header>
      <h2><a href="cards/${card.id}">${card.name}</a></h2>
      <a href="#" class="delete">&#10761;</a>
    </header>
    <ul></ul>
    <form class="new_item">
      <input name="description" type="text">
    </form>`;
  
    let creator = new_card.querySelector('form.new_item');
    creator.addEventListener('submit', sendCreateItemRequest);
  
    let deleter = new_card.querySelector('header a.delete');
    deleter.addEventListener('click', sendDeleteCardRequest);
  
    return new_card;
  }
  
  function createItem(item) {
    let new_item = document.createElement('li');
    new_item.classList.add('item');
    new_item.setAttribute('data-id', item.id);
    new_item.innerHTML = `
    <label>
      <input type="checkbox"> <span>${item.description}</span><a href="#" class="delete">&#10761;</a>
    </label>
    `;
  
    new_item.querySelector('input').addEventListener('change', sendItemUpdateRequest);
    new_item.querySelector('a.delete').addEventListener('click', sendDeleteItemRequest);
  
    return new_item;
  }

  // Adicionei este método para criar o html de uma nova resposta
  function createAnswer(answer , user_name) {
    let new_answer = document.createElement('li');
    new_answer.classList.add('answer');
    new_answer.setAttribute('data-id', answer.id);
    new_answer.innerHTML = `
    <label>
    <span>${answer.content}</span>
    <p>Answered by: ${user_name} </p>
    </label>
    `;
  
  
  
    return new_answer;
  }

  //votes Logic

  document.addEventListener('DOMContentLoaded', function () {
    const upvoteButtons = document.querySelectorAll('.upvote-btn');
    const downvoteButtons = document.querySelectorAll('.downvote-btn');

    upvoteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const questionId = this.getAttribute('data-question-id');
            this.classList.toggle('pressed');
            handleVote('upvote', questionId);
        });
    });

    downvoteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const questionId = this.getAttribute('data-question-id');
            this.classList.toggle('pressed');
            handleVote('downvote', questionId);
        });
    });

    function handleVote(type, questionId) {
        console.log("Question ID", questionId);

       

        fetch(`/questions/${questionId}/${type}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
        })
        .then(response => response.json())
        .then(data => {
            
          const pressedButton = document.querySelector('.pressed');

            console.log(data.message);
            console.log("Number of Upvotes: ", data.number_of_upvotes);

            if(data.message === 'Already voted!') {
                alert('You already voted on this question');
                return;
            }else{

              pressedButton.classList.remove('pressed');
              pressedButton.classList.toggle('voted');

            } 

            //document.querySelector(`[data-question-id="${questionId}"].`).setAttribute('disabled', true);
            //document.querySelector(`[data-question-id="${questionId}"]`).classList.add('voted');
            
            const voteCountElement = document.querySelector(`.vote-count[data-question-id="${questionId}"]`);

            //console.log('Before updating vote count:', voteCountElement.textContent);
            console.log('Before updating vote count:', voteCountElement.textContent);
            console.log('vote count element before', voteCountElement);
           
            // Check if the element exists before updating the text content
            if (voteCountElement) {
                voteCountElement.textContent = data.number_of_upvotes;
            }
            console.log('After updating vote count:', voteCountElement.textContent);
            console.log('vote count element after', voteCountElement);
        })
        .catch(error => console.error(error));
    }
});
  
  addEventListeners();
  