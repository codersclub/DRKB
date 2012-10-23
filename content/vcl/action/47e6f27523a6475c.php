<h1>Создание и регистрация TAction на низком уровне</h1>
<div class="date">01.01.2007</div>


<p>Функция CreateAction (AOwner: TComponent;ActionClass: TBasicActionClass ):TBasicAction;</p>
<p>Модуль: ActnList</p>
<p>Функция создает действие (Action) заданного типа, которое отображается во время проектирования в редакторе списка Action.</p>
<p>Тип Action указывается в параметре ActionClass.</p>
<p>Вызов функции аналогичен выполнению кода ActionClass.Create(AOwner), за исключением того, что функция CreateAction использует значение параметра Resource процедуры RegisterActions для инициализации значений action-объекта, основанного на данном параметре.</p>
<p>Процедура EnumRegisteredActions (Proc: TEnumActionProc;Info: Pointer );</p>
<p>Модуль: ActnList</p>
<p>TEnumActionProc = Procedure( const Category: string;ActionClass: TBasicActionClass;</p>
<p>Info: Pointer ) of object;</p>
<p>Процедура производит итерацию списка зарегистрированных действий (Action), передавая их процедуре повторного вызова, определенной в параметре Proc.</p>
<p>Параметр Category определяет категорию в списке, к которой относится Action. Для потомков TContainedAction параметр Category должен соответствовать свойству TContainedAction.Category. Для первичных классов значение данного параметра может представлять собой пустую строку.</p>
<p>Процедура RegisterActions (const CategoryName: string;const AClasses: array of TBasicActionClass;Resource: TcomponentClass );</p>
<p>Модуль: ActnList</p>
<p>Процедура регистрирует множество Action так, чтобы ими можно было оперировать с помощью редактора списка Action (Action list editor).</p>
<p>Зарегистрированный класс будет отображаться в "Action list editor" при выборе команды редактора "New Action".</p>
<p>Процедура UnRegisterActions (const AClasses: array of TBasicActionClass );</p>
<p>Модуль: ActnList</p>
<p>Отменяет регистрацию множества Action, зарегистрированных ранее процедурой RegisterActions. Множество Action определяется параметром AClasses</p>
<p>Взято с <a href="https://atrussk.ru/delphi/" target="_blank">https://atrussk.ru/delphi/</a></p>
