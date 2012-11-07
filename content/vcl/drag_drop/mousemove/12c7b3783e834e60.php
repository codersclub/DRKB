<h1>Перемещение изображений по форме с помощью мыши</h1>
<div class="date">01.01.2007</div>

<div class="author">Автор: Павел</div>

<p>Во время работы над одной программой предо мной встала задача организации перемещения нескольких изображений пользователем с помощью мыши. Я не крутой мастер DELPHI, и найденное мною решение не претендует на полноту, его недостатки я рассмотрю ниже, но я надеюсь, что опыт, приобретённый при решении будет полезен читателю.</p>
<p>Итак, задача. На форме размещены несколько изображений, загружаемых из внешних файлов (их имена 1.bmp, 2.bmp и т.д.).</p>
<p>Изображения должны быть перемещаемыми с помощью мыши.</p>
<p>Первое решение, пришедшее мне в голову - это решение "в лоб". Разместив на форме несколько Image, заставим их перемещаться вместе с мышью. Разместим на форме в нужных нам местах несколько (n) пустых Image, присвоим их свойству Tag значения от 1 до n - это пригодится при создании массива из них. Объявим следующие переменные:</p>
<pre>
implementation
 
var
  Pic: array[1..n] of TImage; //Сюда мы занесём наши Image
  x0, y0: integer; //Это будут координаты нажатия мыши
  flag: boolean; //а это тоже полезная переменная - флажок
  Для первого из наших Image создадим обработчики следующих событий
  {Как вы уже догадались наша форма называется MainForm}
 
procedure TMainForm.Image1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  if button &lt;&gt; mbLeft then
    flag := false
  else
  begin
    flag := true;
    x0 := x;
    y0 := y
  end
end;
 
{ При нажатии левой клавиши мыши над нашим Image запомним координаты нажатия
и установим флажок. Это делается для того, чтобы Image перемещался только при
опущенной левой кнопке мыши}
 
procedure TMainForm.Image1MouseUp(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  flag := false
end;
 
{При отпускании кнопки мыши, не важно какой, сбросим флажок}
 
procedure TMainForm.Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
  Y: Integer);
begin
  if flag then
  begin //Если флажок установлен, т.е. нажата левая копка мыши
    (Sender as TImage).Left := (Sender as TImage).Left + x - x0;
    (Sender as TImage).Top := (Sender as TImage).Top + y - y0
    //Наш Image начинает перемещаться
  end;
end;
</pre>
<p>Обратите внимание, что перемещается не Image1, а Sender. Созданные нами процедуры будут применены для обработки перемещений всех изображений на форме. Для этого в процедуре создания формы запишем все Image на форме в массив Pic</p>
<pre>
procedure TMainForm.FormCreate(Sender: TObject);
var
  i: byte;
begin
  for i := 0 to MainForm.ComponentCount - 1 do
    if (MainForm.Components[i] is TImage) then
      Pic[MainForm.Components[i].Tag] := (MainForm.Components[i] as TImage);
  {Здесь мы просматриваем компоненты формы и если рассматриваемый компонент
  - TImage присваеваем его в массив Pic c индексом Tag}
  for i := 1 to n do
  begin
    Pic[i].Picture.LoadFromFile(IntToStr(i) + '.bmp'); //Загружаем изображение
    Pic[i].OnMouseDown := Image1MouseDown;
    Pic[i].OnMouseMove := Image1MouseMove;
    Pic[i].OnMouseUp := Image1MouseUp
    {Присваеваем нужные процедуры нужным событиям}
  end
end;
 
{В принципе можно было бы обойтись одним циклом For, но, на мой взгляд
два цикла наглядней и проще для понимания}
</pre>
<p>Итак, полученный код позволяет разместить на форме n изображений и перемещать их с помощью мыши. Можно удовлетвориться полученным решением,если бы не одна страшная проблема - МЕРЦАНИЕ.</p>
<p>Я не большой мастер DELPHI, и я не знаю общего способа, как победить мерцание. Вообще, у меня возникло ощущение, что при перемещеннии Image по форме мерцания не избежать. Буду благодарен тому, кто покажет обратное. Ну в общем применение известных способов, например</p>
<p>MainForm.ControlStyle := MainForm.ControlStyle + [csOpaque];</p>
<p>или процедуры Invalidate мне не помогло.</p>
<p>Следующим моим шагом было посещение Мастеров Дельфи, где я прочёл статью Михаила Христосенко "Перемещение Image'a по форме во время работы программы". Применение метода</p>
<p>(Sender as TImage).SetBounds((Sender as TImage).Left + x - x0, (Sender as</p>
<p>  TImage).Top + y - y0, (Sender as TImage).width, (Sender as TImage).height);</p>
<p>в процедуре Image1MouseMove, рекомендованое Михаилом привело к снижению мерцания, но не избавило от него. Более того, в взрослых программах, таких как например само DELPHI,применяется третий из описанных Михаилом способов - перемещение не изображения, а его рамки.</p>
<p>Тогда я задумался, а не является ли применение TImage для перемещения изображения по форме тупиком. И тут я понял, что знаю компонент, на котором можно разместить изображение, и который не мерцает "по определению". Этот компонент (да простят меня Мастера Дельфи) - форма.</p>
<p>Итак следующий проект состоит из двух форм - FormMain и ImageForm. На ImageForm размещён пустой Image1, занимающий всю клиентскую область ImageForm. ImageForm относится к Available forms - это действие не принципиально, но экономит во время запуска приложения около 100 кб памяти. Свойство BorderStyle для ImageForm устанавливаем bsNone.</p>
<p>Для того, чтобы ImageForm перемещалась за Image1 создаём следующую процедуру:</p>
<pre>
procedure TImageForm.Image1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
const
  SC_DragMove = $F012;
begin
  ReleaseCapture;
  perform(WM_SysCommand, SC_DragMove, 0);
end;
</pre>
<p>На этом работа над ImageForm заканчивается.</p>
<p>Возвращаемся к FormMain.</p>
<p>Сделаем следующие объявления</p>
<pre>
implementation
const
  n = 4; // Сколько нам нужно изображений
uses Unit2;
var
  Fa: array[1..n] of TImageForm;
</pre>
<p>Теперь нам нужно создать массив Fa, разместить его на форме и заполнить его изображениями. Всё это делается вручную - фокус с Tag тут уже не пройдёт. Делать это лучше не во время создания формы, а например во время активации.</p>
<pre>
procedure TFormMain.FormActivate(Sender: TObject);
var
  i: byte;
begin
  for i := 1 to n do
  begin
    Fa[i] := TImageForm.Create(Self); // Создание формы
    Fa[i].Parent := Self;
    //Без этой строки наши формы будут бегать по всему экрану
    Fa[i].Visible := True; //Вывод формы на экран
    Fa[i].Image1.Picture.LoadFromFile(IntToStr(i) + '.bmp'); // Загрузка картинки
    Fa[i].Top := i * 50 //Выбор места расположения (здесь ставятся ваши значения)
  end;
end;
</pre>
<p>Другой вариант - разместить на форме Timer с незначительным интервалом и разместить вышеприведённый код в процедуре OnTimer, указав в конце Timer1.Enabled:=false;</p>
<p>Последний штрих - установите "Отображать содержимое окна при его перетаскивании" с помощью следующей процедуры</p>
<p>B: Bool; //Объявите B где-нибудь после implementation</p>
<p>В FormCreate включите следующее</p>
<p>B := True;</p>
<p>SystemParametersInfo(SPI_SETDRAGFULLWINDOWS, 0, @B, SPIF_SENDCHANGE)</p>
<p>// Не проверял</p>
<p>Ура! В созданная таким образом программе перемещаемые изображения не мерцают.</p>
<p>Однако объём памяти, занимаемый ею во время работы весьма велик. Программа состоящая из вышеприведённых процедур занимает на диске около 400 кб, а в ОП - порядка 2 мб. Попробую поискать менее ресурсоёмкое решение.</p>
<p>Ну вот и всё. Надеюсь, вам понравится. Обругать меня вы можете по адресу yanval@yandex.ru</p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
</p>
<hr /><p class="p_Heading1">Перетаскивание картинки мышью</p>
<p class="p_Heading1"></p>
<div class="author">Автор: Пётр Соболь</div>
<pre>
type
  TMouseState = (msNormal, msDragging);
 
var
  FMouseState: TMouseState;
  OldPos, NewPos: TPoint;
  MaxShift: TPoint;
  bar: integer;
  i: integer;
 
implementation
 
procedure TForm1.Image1MouseDown(Sender: TObject; Button:
  TMouseButton; Shift: TShiftState; X, Y: Integer);
begin
  with Image1 do
  begin
    MaxShift.X := Parent.Width - Width;
    MaxShift.Y := Parent.Height - Height;
  end;
 
  if (MaxShift.X &gt; 0) and (MaxShift.Y &gt; 0) then
    Exit;
 
  if MaxShift.X &gt; 0 then
    MaxShift.X := 0;
  if MaxShift.Y &gt; 0 then
    MaxShift.Y := 0;
 
  FMouseState := msDragging;
  OldPos := Point(X, Y);
end;
 
// обработка переноса
procedure TForm1.Image1MouseMove(Sender: TObject;
  Shift: TShiftState; X, Y: Integer);
begin
  if FMouseState = msDragging then
    with (Sender as TImage) do
    begin
      NewPos := Point(X - OldPos.X, Y - OldPos.Y);
      if Left + NewPos.X &gt; 0 then
        NewPos.X := -Left;
      if Left + NewPos.X &lt; MaxShift.X then
        NewPos.X := MaxShift.X - Left;
      if Top + NewPos.Y &gt; 0 then
        NewPos.Y := -Top;
      if Top + NewPos.Y &lt; MaxShift.Y then
        NewPos.Y := MaxShift.Y - Top;
      Parent.ScrollBy(NewPos.X, NewPos.Y);
    end;
end;
 
//возвращение исходных значений
procedure TForm1.Image1MouseUp(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
  FMouseState := msNormal;
  Screen.Cursor := crDefault;
  with Sender as TImage do
    Label1.Caption := Format('(%d , %d)', [-Left, -Top]); // отображение координат
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
</p>
