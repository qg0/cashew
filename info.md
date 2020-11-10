*  Установлен Code Sniffer и php-cs-fixer и стандарт кодирования Symfony 2, устранены его замечания:
<pre>
8 | ERROR | Missing doc comment for class DecoratorManager
8 | ERROR | Each class must be in a namespace of at least one level (a top-level vendor name)
26 | ERROR | Missing doc comment for function setLogger()
60 | ERROR | Missing doc comment for function getCacheKey()

3 | ERROR | Missing doc comment for class DataProvider
3 | ERROR | Each class must be in a namespace of at least one level (a top-level vendor name)

3 | WARNING | The license block has to be present at the top
  |         |                 of every PHP file, before the namespace
</pre>
и т.д.

* Убран @inheritDoc: @inheritDoc used for member without super members with doc comments
* Классы вынесены в отдельные файлы.
* Добавлены интерфейсы для классов.
* Добавлены геттеры и сеттеры.
* Для улучшения гибкости добавлен отдельно Guzzle клиент. Можно поменять на Curl или другой нужный.
* Добавлены типы для параметров методов и их возвращаемых значений.
* Добавлены комментарии для методов и классов и @var, @param, @throws, @return и т.п.
* Время истечение кеша вынесено в отдельное поле класса и добавлено в конструктор.
* Добавлено сохранение кеша после установки времени истечения.
* Заменён parent::get($input) на $this->get($input).
* Добавлено хэширование ключа кеша и ошибка JSON_THROW_ON_ERROR.
* DecoratorManager изменён на CacheManager т.к. вместо декоратора там внедрение зависимостей для уменьшения связанности.  
* Logger добавлен в конструктор CacheManager как обязательный.
* Добавлена ошибка логгера $e->getMessage();
* $request изменён на $requestArray для понятности содержимого.
* Поправлен $result в DecoratorManager->getResponse() чтобы возвращался массив.
* DataProvider->get() заменён на getData для понятности, внутри запрос к HTTP клиенту.

