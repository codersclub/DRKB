<h1>Текст с эффектами</h1>
<div class="date">01.01.2007</div>

Автор: Релорт<br>
<p>WEB-сайт: http://daddy.mirgames.ru </p>
<p>&nbsp;<br>
&nbsp;<br>
Введение.<br>
Вам когда-нибудь хотелось организовать вывод текста, да не простого, а с наворотами. Так вот эта статья как раз про это. Читайте!<br>
&nbsp;<br>
Благодарность...<br>
Сайту Daddy.h1.ru (MirGames.ru) за то, что там можно найти информацию по DelphiX и скачать файлы со шрифтами :) Большое спасибо!<br>
&nbsp;<br>
&#8230; и информация.<br>
Прошу прошения у тех, кто писал на Relort@xaker.ru в последнее время, за то, что не ответил. В течение последнего месяца я не мог &#171;достучатся&#187; до своего ящика. И вот буквально вчера узнал, что тот на время накрылся :( Так что повторите свои отклики, просьбы, пожелания на новый электронный адрес.<br>
&nbsp;<br>
Также убедительная просьба присылать интересующие вас темы, и если я что-либо смогу по ним сказать, то обязательно это сделаю, оформив ответы в статьи. ОК?<br>
&nbsp;<br>
Часть 1. Базовый класс.<br>
Лирическое отступление: давайте договоримся, что все новые классы и тому подобное мы будем размешать в отдельных файлах. ОК? По крайне мере я собираюсь делать именно так... Итак, создаем новый проект, кидаем на форму TDXDraw, TDXTimer. Теперь создаем новый Unit и обзываем его, например, TextWithEffect_Unit.pas. Приготовления закончены. Приступаем.<br>
<p>Рассуждаем: текст состоит из слов, слова из букв. Вот почему первым созданием в Unit&#8217;е будет: </p>
<pre>
TLetterEffect = record
   Visible: Boolean; //видима ли буква
   CurTime, Delay: Integer; //...
   Scale: Integer; //это и будет нашим эффектом (уменьшение)
end;
 
TLetterEffectArray = array of TLetterEffect;
PLetterEffectArray = ^TLetterEffectArray;
</pre>
<p>То есть описание буквы текста и определение массива букв. Сразу за ним пишем: </p>
<pre>
 
TTextWithEffect = class
private
   FontSurface: TDirectDrawSurface;
   TextSurface: TDirectDrawSurface;
   FText: String;
   FFontSize: Integer;
   FState: Integer;
   FFileName: String;
   LetterEffect: TLetterEffectArray;
   procedure SetText(const Value: String);
   procedure Error(ErrorType: Integer);
   procedure SetFontSize(const Value: Integer);
   procedure SetFileName(const Value: String);
public
   property Text: String read FText write SetText;
   property FontSize: Integer read FFontSize write SetFontSize;
   property FileName: String read FFileName write SetFileName;
   procedure Draw(Surface: PDirectDrawSurface);
   constructor Create(DD: PDirectDraw);
   destructor Destroy;
end;
</pre>
<p>Надеюсь здесь все понятно? Нет!? Ну тогда ладно:<br>
FontSurface &#8211; поверхность (TDirectDrawSurface), содержащая алфавит.<br>
TextSurface - поверхность (TDirectDrawSurface), содержащая текст к выводу.<br>
LetterEffect &#8211; буквы текста.<br>
Text &#8211; текст к отрисовке.<br>
FontSize &#8211; размер каждой буквы текста. Здесь надо оговорится: каждая буква текста берется из файла с именем FileName (третье свойство TTextWithEffect), т. е. FileName &#8211; имя файла с алфавитом (см. архив, прилагаемый к статье, файл Font.bmp); и для заполнение TextSurface&#8217;а необходим размер каждой буквы.<br>
Ну и так далее...<br>
&nbsp;<br>
А сейчас самое интересное: создание эффекта и просмотр результата.<br>
&nbsp;<br>
Часть 2. Эффект и отрисовка.<br>
&nbsp;<br>
Для данного примера я опишу лишь один эффект &#8211; уменьшение букв с течением времени. Этот эффект довольно просто реализовать с учетом вышеописанного класса TLetterEffect. В том классе за текущее состояние эффекта буквы отвечала переменная Scale. Все что нам нужно &#8211; уменьшать ее во времени (но до определенного момента).<br>
<p>А вот и сама процедура, принимающая в качестве аргумента указатель на массив букв. Вот... </p>
<pre>
//Эффект
procedure ScaleDown(L: PLetterEffectArray);
var
   i: Integer;
begin
   for i:=0 to High(L^) do
   begin
      if L^[i].Scale &lt; 0 then
      begin
         inc(L^[i].CurTime);
         if L^[i].CurTime &lt;= L^[i].Delay then
         dec(L^[i].Scale, 1);
         exit;
      end;
   end;
end;
// ну и отрисовка
procedure TTextWithEffect.Draw(Surface: PDirectDrawSurface);
var
   i: Integer;
   rc: TRect;
   rc1: Trect;
   s: Integer;
begin
   if FontSurface = nil then exit;
   if FText = '' then exit;
   // рисуем текст без эффекта
   Surface^.Draw(32, 32, TextSurface.ClientRect, TextSurface, True);
   // вносим изменения в эффект
   ScaleDown(@LetterEffect);
   // и выводим текст с эффектом побуквенно
   for i:=0 to High(LetterWithEffect) do
   begin
      s := LetterEffect[i].Scale;
      if s = 32 then exit;
      rc1 := Rect(i*16,0,(i+1)*16,16);
      if s &lt; 0 then
      begin
         rc := Rect(i*16+32-s, 64-s, ((i+1)*16)+32+s, 80+s);
         Surface^.StretchDraw(rc, rc1, TextSurface, True);
      end
      else Surface^.Draw(i*16+32, 64, rc1, TextSurface, True)
   end;
end;
</pre>
<p>Заключение.<br>
Посмотрите файл TWE_Ex.exe.<br>
Вот чего можно добиться расширив данный пример :) !!!<br>
&nbsp;<br>
&nbsp;<br>
Ну вот вроде бы как и все. Мы добрались до завершения статьи. Если что непонятно, необходимо пояснение или пример пишите. Отвечу всем.<br>
<div class="author">Автор: Релорт Relort@yandex.ru Февраль 2003. </div>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
