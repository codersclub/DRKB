<h1>Отображение текста с тегами форматирования</h1>
<div class="date">01.01.2007</div>


<pre>{ **** UBPFD *********** by delphibase.endimus.com ****
&gt;&gt; Отображение текста с тегами форматирования
 
Рисует строку текста, содержащую теги форматирования, походие на теги HTML.
 
Поддерживаются следующие теги:
&lt;b&gt;..&lt;/b&gt; Полужирный
&lt;i&gt;..&lt;/i&gt; Наклонный
&lt;u&gt;..&lt;/u&gt; Подчёркнутый
&lt;s&gt;..&lt;/s&gt; Перечёркнутый
 
&lt;big[ n]&gt;..&lt;/big&gt; Увеличить ращмер шрифта на n единиц (по умолчанию 1)
&lt;small[ n]&gt;..&lt;/small&gt; Уменьшить шрифт на n единиц (по умолчанию 1)
 
&lt;sub&gt;..&lt;/sub&gt; Нижний индекс
&lt;sup&gt;..&lt;/sup&gt; Верхний индекс
Для правильного отображения внутри тегов &lt;sub&gt; и &lt;sup&gt; не должно располагаться других тегов
 
&lt;font name="Имя шрифта" size="Размер" color="Цвет" charset="Кодовая страница"&gt;..&lt;/font&gt; 
Установка параметров шрифта.
Размер шрифта указывается как для свойства TFont.Size, а не как в HTML. 
В качестве цвета можно указывать либо константы clXXXX либо числа в формате #RRGGBB, 
где RR GG и ВВ соответственно шестнадцатеричные значения 00..FF красной, 
зелёной и синей составляющей, HTML цвета не поддерживаются. В параметре charset 
указываются константы XXXX_CHARSET, например RUSSIAN_CHARSET или ANSI_CHARSET
 
Зависимости: Windows, SysUtils, Classes, Graphics, Dim
Автор:       Dimka Maslov, mainbox@endimus.com, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        17 марта 2004 г.
***************************************************** }
 
unit HtDraw;
 
interface
 
uses Windows, SysUtils, Classes, Graphics, Dim;
 
type
  TTag = class;
 
  THtDraw = class(TObject)
  private
    FTag: TTag;
    FText: TString;
    procedure SetText(Value: TString);
  public
    function Draw(Canvas: TCanvas; X, Y: Integer): Integer;
    // Canvas - устройство для отображения текста.
    // в свойстве Canvas.Font задаются начальные параметры шрифта
    // X, Y - начальные координаты
    // Функция возвращает сумму X и ширины выведенного текста
    property Text: TString read FText write SetText;
    // Задаёт текст для отображения. В отличие от свойств компонентов,
    // присвоение значения этого свойства не приводит к автоматической
    // перерисовке. Необходимо вызывать метод Draw
    constructor Create(const AText: TString);
    destructor Destroy; override;
  end;
 
 
</pre>
<p>Полный текст модулей располагается по адресам:</p>
<p>HtDraw: http://downloads.endimus.com/htdraw.zip</p>
<p>Dim : http://downloads.endimus.com/dimpas.zip</p>
<p>Пример использования:</p>
<pre>var
  HtDraw: THtDraw;
begin
  HtDraw :=
    THtDraw.Create('&lt;b&gt;T&lt;/b&gt;&lt;i&gt;e&lt;/i&gt;&lt;u&gt;s&lt;/u&gt;&lt;s&gt;t&lt;/s&gt;');
  try
    HtDraw.Draw(Canvas, 10, 10);
  finally
    HtDraw.Free;
  end;
end;
</pre>


