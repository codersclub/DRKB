---
Title: Введение и базовые понятия
Date: 01.01.2007
Author: Тенцер А. Л. <tolik@katren.nsk.ru> ICQ UIN 15925834
---

## Delphi и COM


Введение и базовые понятия
==========================

### Введение

COM (Component Object Model) или модель объектных компонентов - одна из
основных технологий, на который основывается Windows. Более  того, все
новые технологии в Windows (Shell, Scripting, поддержка HTML и т.п.)
реализуют свои API именно в виде COM интерфейсов. Таким образом, в
настоящее время профессиональное программирование требует понимания
модели COM и умения с ней работать. В этой главе мы рассмотрим основные
понятия COM и особенности их поддержки в Delphi.

### Базовые понятия

Основным понятием, на котором основана модель COM, является понятие
интерфейса. Не имея четкого понимания о том, что такое интерфейс
невозможно успешное программирование COM-объектов. Главными понятиями
являются интерфейс и реализация интерфейса.

### Интерфейс

Интерфейс является контрактом, между программистом и компилятором.

Программист - обязуется реализовать все методы, описанные в интерфейсе
и следовать требованиям на реализацию некоторых их них.

Компилятор - обязуется создать в программе внутренние структуры,
позволяющие обращаться к методам этого интерфейса из любого
поддерживающего те же соглашения средства программирования. Таким
образом, COM является языково-независимой технологией и может
использоваться в качестве «клея», соединяющего программы, написанные на
разных языках.

Объявление интерфейса включает в себя описание методов и их параметров,
но не включает их реализации. Кроме этого, в объявлении может
указываться идентификатор интерфейса - уникальное 16-байтовое число,
сгенерированное по специальным правилам, гарантирующим его
статистическую уникальность (GUID - global unique identifier).

Интерфейсы могут наследоваться. Наследование интерфейсов - это
декларация, указывающая, что унаследованный интерфейс должен включать в
себя все методы предка.

Таким образом, необходимо понимать, что:

- Интерфейс - это не класс.

Класс может выступать реализацией интерфейса, но класс содержит код
методов на конкретном языке программирования, а интерфейс - нет.

- Интерфейс строго типизирован.

Как клиент, так и реализация интерфейса должны использовать точно те же
методы и параметры, как указано в описании интерфейса.

- Интерфейс является неизменным контрактом.

Вы не должны определять новой версии того же интерфейса с измененным
набором методов (или их параметров), но с тем же идентификатором. Это
гарантирует, что новые интерфейсы никогда не конфликтуют со старыми.
Если Вы нуждаетесь в расширении функциональности, Вы должны определить
новый интерфейс, возможно являющийся наследником старого и реализовать
дополнительные методы в нем.

Реализация интерфейса - это непосредственно код, который реализует эти
методы. При этом за несколькими исключениями, не накладывается никаких
ограничений на то, каким образом будет выглядеть реализация. Физически
реализация представляет собой массив указателей на методы, адрес
которого и используется в клиенте для доступа к COM-объекту. Любая
реализация интерфейса имеет метод QueryInterface, позволяющий запросить
ссылку на конкретный интерфейс из числа реализуемых.

### Автоматическое управление памятью и подсчет ссылок

Кроме предоставления независимого от языка программирования доступа к
методам объектов COM реализует автоматическое управление памятью для
COM-объектов. Оно основано на идее подсчета ссылок на объект. Любой
клиент, желающий использовать COM объект после его создания должен
вызвать заранее предопределенный метод, который увеличивает внутренний
счетчик ссылок на объект на единицу. По завершении использования объекта
клиент вызывает другой его метод, уменьшающий значение этого же
счетчика. При достижении счетчиком ссылок нулевого значения COM-объект
автоматически удаляет себя из памяти. Такая модель позволяет клиентам не
вдаваться в подробности реализации объекта, а объекту - обслуживать
несколько клиентов и корректно очистить память по завершении работы с
последним из них.

### Объявление интерфейсов

Для поддержки интерфейсов Delphi расширяет синтаксис языка Pascal
дополнительными ключевыми словами. Объявление интерфейса в Delphi
реализуется ключевым словом interface

     
    type
      IMyInterface = interface
      ['{412AFF00-5C21-11D4-84DD-C8393F763A13}']
        procedure DoSomething(var I: Integer); stdcall;
        function DoSomethingAnother(S: String): Boolean;
      end;
     
      IMyInterface2 = interface(IMyInterface)
      ['{412AFF01-5C21-11D4-84DD-C8393F763A13}']
        procedure DoAdditional(var I: Integer); stdcall;
      end;

Для генерации нового значения GUID в IDE Delphi служит сочетание клавиш
Ctrl+Shift+G.

**IUnknown**

Базовым интерфейсом в модели COM является IUnknown. Любой интерфейс
наследуется от IUnknown и обязан реализовать объявленные в нем методы.
IUnknown объявлен в модуле System.pas следующим образом:

    type
      IUnknown = interface
        ['{00000000-0000-0000-C000-000000000046}']
        function QueryInterface(const IID: TGUID; out Obj): HResult; stdcall;
        function _AddRef: Integer; stdcall;
        function _Release: Integer; stdcall;
      end;

Рассмотрим назначение методов IUnknown более подробно.

Последние два метода предназначены для реализации механизма подсчета
ссылок.

    function _AddRef: Integer; stdcall;

Эта функция должна увеличить счетчик ссылок на интерфейс на 1 и вернуть
новое значение счетчика.

    function _Release: Integer; stdcall;

Эта функция должна уменьшить счетчик ссылок на интерфейс на 1 и вернуть
новое значение счетчика. При достижении счетчиком значения 0 она должна
освободить память, занятую реализацией интерфейса.

Первый метод позволяет получить ссылку на реализуемый классом интерфейс.

    function QueryInterface(const IID: TGUID; out Obj): HResult; stdcall;

Эта функция получает в качестве входного параметра идентификатор
интерфейса. Если объект реализует запрошенный интерфейс, то функция:

- возвращает ссылку на него в параметрt Obj
- вызывает метод \_AddRef полученного интерфейса
- возвращает 0

В противном случае, функция возвращает код ошибки E\_NOINTERFACE.

В принципе, конкретная реализация может наполнить эти методы какой-либо
другой, отличающейся от стандартной функциональностью, однако в этом
случае интерфейс будет несовместим с моделью COM, поэтому делать этого
не рекомендуется.

В модуле System.pas объявлен класс TInterfacedObject, реализующий
IUnknown и его методы. Рекомендуется использовать этот класс для
создания реализаций своих интерфейсов.

Кроме этого, поддержка интерфейсов реализована в базовом классе TObject.
Он имеет метод

    function TObject.GetInterface(const IID: TGUID; out Obj): Boolean;

Если класс реализует запрошенный интерфейс, то функция:

- возвращает ссылку на него в параметрt Obj
- вызывает метод \_AddRef полученного интерфейса
- возвращает TRUE

В противном случае, функция возвращает FALSE.

Таким образом, имеется возможность запросить у любого класса Delphi
реализуемый им интерфейс Подробнее использование этой функции будет
рассмотрено ниже.
