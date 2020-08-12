# APIdocumentor

Описание API
  Данное API представляет собой хранилище документов пользователей с возможностью чтения добавления, редактирования и удаления документов. Пользователь имеет возможность хранить неограниченное количество документов.
  Взаимодействие между API и клиентов основано на передаче данных в формате JSON.

Начало работы
  Все нижеперичисленные примеры основаны на обращении к API с помощью утилиты cURL, что обеспечивает минималистичный подход в обращении к API. Методы запросов и отправляемые данные будут уникальными для всех клиентских реализаций
  
  Если вы не зарегистрированы в системе, необходимо провести регистрацию пользователя:
	
   curl -d @reghUser.json -H "Content-Type: application/json" -X POST http://yourservername/registration
    Примечание 1: Для всех последующих запросов с телом запроса, используется заголовок "Content-Type: application/json"
    Примечание 2: все ключи в теле запроса в данном и последующих примерах, должны соответствовать ожидаемых ключам на стороне API, в противном случае, API вернет заголовок "HTTP/1.1 400 Bad Request" с телом ответа "Ошибка передачи: Ожидаемый запрос отличается от фактического".
    
  Авторизация:
	
   Процесс авторизации представляет собой идентификацию пользователя в системе, генерацию и выдачу уникального токена привязанного к id идентифицированного пользователя.
	
   curl -d @authUser.json -H "Content-Type: application/json" -X POST http://yourservername/authorization
     В ответ придет токен, необходимый для аутентификации пользователя при чтении, создания,редактирования и удалении документов. Скопируйте его куда нибудь.
  Работа с документами:
    Для создания документа, выполните следующий запрос:
		
   curl -d @addDocument.json -H "Authorization:your_token" -H "Content-Type: application/json" -X POST http://yourservername/documents/createdocument
   Теперь вы можете получить список своих документов :
		
   curl -H "Authorization:your_token" http://yourservername/documents/getdocuments
		
   Или же конкретный документ посредством указания GET параметра id
		
   curl -H "Authorization:your_token" http://yourservername/documents/getdocument?id=n
      В случае, если документ с заданным id не найден у аутентифицированного пользователя API вернет заголовок "HTTP/1.1 400 Bad Request" с телом ответа "Документ не найден".
			
   Для редактирования документа, выполните следующий запрос:
	 
   curl -d @editDocument.json -H "Authorization:your_token" -H "Content-Type: application/json" -X PUT http://yourservername/documents/editdocument
	 
   В случае, если документ с соответствующим id в теле запроса не будет найден у пользователя или вовсе не будет существовать, или данные в теле запроса будут абсолютно идентичны данным редактируемого документа, то API вернет заголовок "HTTP/1.1 400 Bad Request" с телом ответа "Данный документ не существует или внесенные данные совпадают с таковыми в документе".
	 
   Для удаления документа, выполните следующий запрос:
	 
   curl -d @deleteDocument.json -H "Authorization:your_token" -H "Content-Type: application/json" -X DELETE http://yourservername/documents/deletedocument
