<h1>Показ всплывающих подсказок в строке состояния</h1>
<div class="date">01.01.2007</div>

Я покажу как сделать так, чтобы строка состояния (Status Bar) показывала все всплывающие подсказки (Hint) элементов управления формы при нахождении курсора мыши в области компонента. Имеется пара решений данной задачи, но в любом случае вы должны создать код для каждой формы (пока я не знаю другого решения).</p>
<p>Шаг 1:</p>
<p>Расположите TStatusBar на всех формах, где вы хотите увидеть подсказки в строке состояния. Установите свойство SimplePanel в True и присвойте компоненту другое имя (я использую SBStatus). Смотри мой комментарий относительно имени, который я поместил в шаге 4.</p>
<p>Шаг 2:</p>
<p>Создайте необходимые подсказки в свойствах Hint. Не забудьте вставить '|', если вам необходим длинный текст.</p>
<p>Шаг 3:</p>
<p>Поместите следующую строку в обработчике события FormCreate вашей формы:</p>
Application.OnHint := DisplayHint;</p>
<p>Шаг 4:</p>
<p>Создайте эту процедуру. Пожалуйста обратите внимание на комментарии.</p>
<pre>
procedure TFrmMain.DisplayHint(Sender: TObject);
var
  Counter, NumComps: integer;
begin
  with Screen.ActiveForm do
  begin
    NumComps := ControlCount - 1;
    for Counter := 0 to NumComps do
      {SBStatus - имя всех моих компонентов TStatusBar.
      При необходимости его можно изменить.}
      if (TControl(Controls[Counter]).Name = 'SBStatus') then
      begin
        if (Application.Hint = '') then
          {ConWorkingName - используемая константа.
          При необходимости ее можно изменить.}
          TStatusBar(Controls[Counter]).SimpleText := ConWorkingName
        else
          TStatusBar(Controls[Counter]).SimpleText := Application.Hint;
        break;
      end;
  end;
end; {DisplayHint}
</pre>
<p>Не забудьте поместить 'Procedure DisplayHint(Sender: TObject) в секции Public.</p>
<p>Это все, что вы должны сделать. Если вы хотите придать такую функциональность другим формам, просто поместите на них TStatusBar и установите свойство Hint у необходимых компонентов. Я надеюсь это просто.</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<div class="author">Автор: Иваненко Фёдор Григорьевич </div>
<p>Пришло мне письмо:</p>
<p>...cовет за номером 000306 содержит интересную идею -- выводить Hint'ы не на основную форму, а на активную, я сам до этого не дошел... Но не совсем понятно, чем автору не понравился стандартный метод TForm.FindComponent, существующий со времен Delphi I ? С его использованием метод ShowHint выглядит попроще, да и работает не хуже:</p>
<pre>
procedure TAnyForm.ShowHint;
var
  C: TStatusBar;
begin
  // ищем наш StatusBar1 на активной форме
  C := TStatusBar(Screen.ActiveForm.FindComponent('StatusBar1'));
  // если не найден -- ищем на основной форме
  if not Assigned(C) then
    C := TStatusBar(Application.MainForm.FindComponent('StatusBar1'));
  // если что-то обнаружено -- рисуем на н?м наш текст
  if Assigned(C) then
    C.SimpleText := '  ' + Application.Hint;
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
