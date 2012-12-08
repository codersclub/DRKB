---
Title: Написание приложений под .NET Framework 2.0 в Delphi 8 -- Delphi 2006
Date: 01.01.2007
---


Написание приложений под .NET Framework 2.0 в Delphi 8 -- Delphi 2006
=====================================================================

::: {.date}
01.01.2007
:::

Статья детально описывает шаги, которые необходимо выполнить, чтобы
написать и скомпилировать полноценное .NET 2.0 приложение в Delphi8,
Delphi 2005 или BDS 4 под второй фреймворк (Microsoft .NET 2.0
Framework).\
 \
1.0. Введение\
Как нам всем известно, Borland на данный момент переживает не самые
лучшие времена. Delphi похоже в скором времени сменит своего хозяина, но
а тем временем мир не стоит на месте. После выхода BDS 4 (Borland
Developer Studio 4, он же Delphi 2006) появился Microsoft .NET Framework
2.0, значительно более улучшенный, нежели его предшественник, и перед
программистами, работающими в Delphi, встал закономерный вопрос --
«Когда появится следующая BDS, поддерживающая .NET Framework 2.0?». К
сожалению, официально ни Delphi 8, ни Delphi 2005, ни BDS 4 не
поддерживают фреймворк второй версии, что открывает перед Delphi
программистами не совсем радужную перспективу. Ведь они фактически
остаются «не у дел».\
Но пока новая версия BDS находится в разработке, многие программисты
естественно стали искать пути «научить» BDS 4 работе с .NET 2.0. Цель
данной статьи заключается в том, чтобы подробно описать те шаги, которые
необходимо сделать для успешного создания полноценных .NET 2.0
приложений в текущих версиях Delphi, начиная с восьмой.\
NET Framework 2.0 в отличие от своего предшественника предоставляет
целый ряд новых элементов управления и множество новых классов,
благодаря чему, приложения, написанные под него больше не будут походить
на те, что писались во времена первой Delphi с минимальным набором
элементов управления и классов. Естественно, Я обращу внимание именно на
эти нововведения. Но для начала, Я расскажу о том, в чём секрет создания
.NET 2.0 приложений под BDS 4.\
 \
Внимание: В этой статье Я буду ориентироваться на BDS 4, так как не имею
под рукой компиляторов от восьмёрки и Delphi 2005. Если у Вас Delphi
младше 2006, то Я не могу гарантировать работоспособность примеров,
описанных в статье. Тем не менее, обе предыдущие версии Delphi имеют
.NET компилятор и Я не думаю, что он кардинально отличается от того, что
есть в BDS 4.\
 \
2.0. Использование .NET компилятора Delphi и работа с его командной
строкой.\
Есть несколько способов получения скомпилированного приложения. Первый
это использование для компиляции самой среды BDS (или сторонней среды,
если таковая имеется), а второй это работа с Delphi .NET компилятором
напрямую, посредством командной строки. Именно этот второй способ и есть
ключ к созданию .NET 2.0 приложений в Delphi.\
Дело в том, что .NET компилятор Delphi разрешает указание версии
фреймворка, который будет использован для компиляции данного приложения.
Поэтому, если на вашей машине установлен второй фреймворк, то мы сможем
указать для компиляции именно его. А это значит, что мы автоматически
получим возможность использовать и все нововведения второго фреймворка.\
Обратная сторона медали заключается в том, что мы не сможем «нормально»
писать программу. Например, если Вы пишете WinForms приложение, то,
скорее всего, используете дизайнер форм для создания интерфейса
приложения. Но так как BDS 4 не поддерживает второго фреймворка, то Вы
не сможете располагать на форме его элементы управления. Кроме того, Вы
не сможете пользоваться Code Insight возможностями среды. Одним словом,
писать полноценные .NET 2.0 приложения возможно. Это трудно и
утомительно, долго и изматывающе, из вашей комнаты будет, скорее всего,
доноситься трёхэтажный мат, но это возможно.\
В следующей главе Я подробно расскажу о параметрах командной строки,
которые мы будем использовать, и мы приступим к написанию нашего первого
.NET 2.0 приложения в Delphi, если так можно сказать.\
 \
2.1. Настройка компилятора с помощью командной строки.\
Давайте посмотрим на директивы командной строки, которые предлагает .NET
компилятор Delphi. Выберите «Пуск -\> Выполнить» и введите cmd. В
появившемся окне консоли введите dccil --help.\
Перед Вами предстанет листинг всех параметров командной строки,
поддерживаемых компилятором:\
![clip0176](/pic/clip0176.gif){width="719" height="418"}

Описание всех этих параметров можно найти в справке Delphi. Нас же
больше всего интересует параметр \--clrversion, именно он ответственен
за выбор версии фреймворка. Кроме того, нам понадобится параметр
\--no-config, это заставит компилятор не загружать файл конфигурации по
умолчанию, который, конечно же, совсем не дружит с .NET Framework 2.0.
Кроме этих параметров нам понадобятся ещё несколько, но о них будет
сказано по мере написания наших .NET 2.0 программ.\
 \
3.0. Написание консольного .NET 2.0 приложения в Delphi.\
Вот мы и подошли к самому интересному. Сейчас мы напишем консольное
приложение, которое будет использовать новые возможности .NET Framework
2.0. Для наглядного примера Я взял свойства ForegroundColor,
BackgroundColor класса Console и класс ConsoleColor, позволяющие
изменять внешний вид консоли в приложении. Почему именно они? Да потому
что они отсутствуют в .NET 1.1, и потому, если наш эксперимент пройдёт
удачно (в чём можно не сомневаться ![](/pic/embim1915.png){width="288"
height="96"}), то можно будет смело констатировать факт -- полученное
приложение есть .NET 2.0 программа.\
Итак, запустите BDS 4 for Microsoft .NET и создайте новый консольный
проект. Сохраните его, дав название ConsoleApp. Переключайтесь на
редактор кода и вводите следующий код:\

    program ConsoleApp;

    {$APPTYPE CONSOLE}

    begin
    // В .NET Framework 1.1 отсутствует класс ConsoleColor и свойства
    // ForegroundColor и BackgroundColor у класса Console.
    // Поэтому из BDS 4.0, которая обучена работе только с .NET 1.1,
    // не получится скомпилировать данный проект.
    // Используйте командную строку, чтобы самостоятельно указать
    // компилятору нужный framework.
    Console.ForegroundColor := ConsoleColor.Blue;
    Console.BackgroundColor := ConsoleColor.Yellow;
    Console.WriteLine('***************************************');
    Console.WriteLine('*** HELLO FROM NET 2.0 Application! ***');
    Console.WriteLine('***************************************');
    Console.ForegroundColor := ConsoleColor.Green;
    Console.BackgroundColor := ConsoleColor.Black;
    Console.WriteLine('Информация о Вашей ОС:');
    Console.WriteLine(System.Environment.OSVersion.Version);
    Console.WriteLine(System.Environment.OSVersion.VersionString);
    Console.ReadLine;
    end.

При попытке скомпилировать данное приложение мы естественно получим
сообщения об ошибках от компилятора, который безуспешно пытается найти
несуществующие в первом фреймворке свойства и классы. Сохраните проект и
смело выходите из BDS. Наш следующий шаг -- использование .NET
компилятора Delphi из командной строки.\
Создайте make.bat файл в директории с вашим консольным проектом. Мы
пропишем синтаксис команды в этом файле, чтобы не указывать полные пути
к файлам проекта. Откройте файл для редактирования и введите следующее:\

dccil -CC -NSC:\\WINDOWS\\Microsoft.NET\\Framework\\v2.0.50727
\--clrversion:v2.0.50727 \--no-config ConsoleApp.dpr pause

Первый параметр (-CC) указывает на то, что мы хотим получить консольное,
а не GUI приложение на выходе. Параметр --NS указывает полный путь к
библиотекам используемого фреймворка. Параметр ---clrversion заставит
компилятор использовать для компиляции проекта второй фреймворк. Далее
мы отказываемся от конфига по умолчанию и указываем файл проекта для
компиляции. Pause это моя собственная прихоть. Не люблю когда батники
автоматически закрываются по завершении задачи .\
 \
Примечание: Если Windows установлен у Вас не на системном разделе ©, а
на другом разделе, то не забудьте изменить путь в параметре --NS на
верный.\
 \

После запуска файла make.bat на исполнение Вы увидите следующее
сообщение:

![clip0177](/pic/clip0177.gif){width="668" height="331"}

Компилятор сообщит о том, что файл Borland.Delphi.System.dcuil не
найден. Это системный файл, в котором содержится описание типов данных и
основных классов приложения. Он необходим при компиляции любого .NET
приложения. В нашем случае мы должны просто скопировать этот файл в
директорию с проектом и перекомпилировать его под второй фреймворк.
Делается это следующим образом.

dccil -CC -NSC:\\WINDOWS\\Microsoft.NET\\Framework\\v2.0.50727
\--clrversion:v2.0.50727 \--no-config -Q -M -y -Z -\$D-
Borland.Delphi.System.pas\
pause

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"}
  --- ---------------------------------------------------------------------------------------------------------------------------------
  ·   Эта команда приведёт к компиляции Borland.Delphi.System.pas и получению так необходимого нам файла Borland.Delphi.System.dcuil.
  --- ---------------------------------------------------------------------------------------------------------------------------------
:::

 \

Снова запускайте make.bat. В директории проекта появится
скомпилированный файл ConsoleApp.exe, а также ещё несколько
скомпилированных библиотек второго .NET. Запускайте приложение и вуаля!
Мы видим, что приложение прекрасно работает, более того, видно, что
текст в консоли имеет разные цвета. Это говорит о том, что классы
второго фреймворка дают о себе знать и замечательно работают:

Для ещё большей уверенности можете попробовать запустить это приложение
на машине без установленного второго фреймворка.\
Как видите, у нас получилось создать полноценное .NET 2.0 приложение. Вы
можете пробовать экспериментировать с другими классами и новыми
свойствами второго фреймворка и Я Вас уверяю, они будут работать.\
Мы написали консольное приложение. Но одной консолью, пусть даже и на
втором фреймворке, сыт не будешь. В следующей главе Я расскажу о
создании уже WinForms приложения под .NET 2.0.\
 \
Примечание: По вполне понятным причинам Я не могу приложить файл
Borland.Delphi.System.dcuil к статье, так как он защищён авторскими
правами Borland. Не пытайтесь просить меня дать Вам его или выложить
где-нибудь. Вы должны самостоятельно получить этот файл, взяв
Borland.Delphi.System.pas за основу из вашего собственного дистрибутива
BDS.\
 \
4.0. Высший пилотаж -- пишем полноценное .NET 2.0 WinForms приложение.\
Написание WinForms приложения почти ни чем не отличается от написания
консольного. Для наглядной демонстрации возможностей .NET 2.0 Я решил
привести пример с элементом управления ToolStrip. Этот контролл появился
лишь во втором фреймворке и предназначен для создания наборов панелей
инструментов в стиле Microsoft Office 2003 или Microsoft Visual Studio
2005. Хотите такие же в своём Delphi .NET приложении? Конечно же, чёрт
возьми, хотите ![](/pic/embim1916.png){width="288" height="96"}. Ну, по
крайней мере, сам факт их присутствия в Delphi .NET приложении,
написанном в BDS 4 Вас наверное удивит
![](/pic/embim1917.png){width="288" height="96"}.\
Запускайте BDS for Microsoft .NET и создайте новый WinForms проект.
Сохраните его под названием WinFormsApp и, оставив форму пустой,
закрывайте BDS. Нам она вряд ли ещё понадобится. Далее так же, как и для
консольного проекта, создайте файл Borland.Delphi.System.dcuil
командой:\
dccil -CG -NSC:\\WINDOWS\\Microsoft.NET\\Framework\\v2.0.50727
\--clrversion:v2.0.50727 \--no-config -Q -M -y -Z -\$D-
Borland.Delphi.System.pas\
pause Скопируйте файл make.bat из консольного проекта в текущий и
измените его содержание на следующее:\
dccil -CG -NSC:\\WINDOWS\\Microsoft.NET\\Framework\\v2.0.50727
\--clrversion:v2.0.50727 \--no-config WinFormsApp.dpr
-luC:\\WINDOWS\\Microsoft.NET\\Framework\\v2.0.50727\\System.Windows.Forms.dll
-luC:\\WINDOWS\\Microsoft.NET\\Framework\\v2.0.50727\\System.Data.dll
-luC:\\WINDOWS\\Microsoft.NET\\Framework\\v2.0.50727\\System.Drawing.dll
-luC:\\WINDOWS\\Microsoft.NET\\Framework\\v2.0.50727\\System.XML.dll\
pause В этой команде мы заменили параметр CC на CG, так как хотим
получить GUI приложение, а не консольное. Кроме того, помимо библиотеки
Borland.Delphi.System.dcuil для WinForms приложения нам понадобятся
дополнительные библиотеки из самого .NET. Мы указали их с помощью
параметра --lu. Искать их и копировать в директорию с программой не
надо. Компилятор сам обнаружит их и создаст скомпилированный dcuil из
них в директории с программой.\

Теперь приступим к написанию кода. Так как дизайнер форм мы использовать
не можем, то все элементы управления придётся создавать вручную в
рантайм. Открывайте pas файл формы в текстовом редакторе и вписывайте в
конструктор формы следующий код:

    constructor TWinForm.Create;
    var
    DockSite: ToolStripContainer; // Область присоединению панелей управления
    NewMenuStrip: MenuStrip; // Главное меню
    NewToolStrip: ToolStrip; // Панель управления
    FileToolStripMenuItem,
    NewToolStripMenuItem,
    EditToolStripMenuItem,
    ViewToolStripMenuItem: ToolStripMenuItem;
    NewButton: ToolStripButton;
    begin
    inherited Create;
    //
    // Required for Windows Form Designer support
    //
    InitializeComponent;
    //
    // TODO: Add any constructor code after InitializeComponent call
    //
    // DockSite
    DockSite := System.Windows.Forms.ToolStripContainer.Create;
    DockSite.ContentPanel.Size := System.Drawing.Size.Create(292, 224);
    DockSite.Dock := System.Windows.Forms.DockStyle.Fill;
    DockSite.Location := System.Drawing.Point.Create(0, 0);
    DockSite.Name := 'DockSite';
    DockSite.Size := System.Drawing.Size.Create(292, 273);
    DockSite.TabIndex := 0;
    DockSite.Text := 'DockSite';
    DockSite.Parent := Self;
    DockSite.Visible := True;
    // NewMenuStrip
    NewMenuStrip := System.Windows.Forms.MenuStrip.Create;
    NewMenuStrip.Name := 'NewMenuStrip';
    NewMenuStrip.ClientSize := System.Drawing.Size.Create(292, 24);
    NewMenuStrip.Location := System.Drawing.Point.Create(0, 0);
    NewMenuStrip.Text := 'NewMenuStrip';
    NewMenuStrip.TabIndex := 0;
    // NewToolStrip
    NewtoolStrip := System.Windows.Forms.ToolStrip.Create;
    NewToolStrip.Dock := System.Windows.Forms.DockStyle.None;
    NewtoolStrip.Location := System.Drawing.Point.Create(3, 24);
    NewtoolStrip.Name := 'NewToolStrip';
    NewtoolStrip.Size := System.Drawing.Size.Create(74, 25);
    NewtoolStrip.TabIndex := 1;
    // FileToolStripMenuItem
    FileToolStripMenuItem := System.Windows.Forms.ToolStripMenuItem.create;
    FileToolStripMenuItem.Name := 'FileToolStripMenuItem';
    FileToolStripMenuItem.Size := System.Drawing.Size.Create(45, 20);
    FileToolStripMenuItem.Text := '&Файл';
    // NewToolStripMenuItem
    NewToolStripMenuItem := System.Windows.Forms.ToolStripMenuItem.create;
    NewToolStripMenuItem.Name := 'NewToolStripMenuItem';
    NewToolStripMenuItem.Size := System.Drawing.Size.Create(107, 22);
    NewToolStripMenuItem.Text := '&Новый';
    // Обработчик для команды
    Include(NewToolStripMenuItem.Click, NewToolStripMenuItem_Click);
    // EditToolStripMenuItem
    EditToolStripMenuItem := System.Windows.Forms.ToolStripMenuItem.create;
    EditToolStripMenuItem.Name := 'EditToolStripMenuItem';
    EditToolStripMenuItem.Size := System.Drawing.Size.Create(56, 20);
    EditToolStripMenuItem.Text := '&Правка';
    // ViewToolStripMenuItem
    ViewToolStripMenuItem := System.Windows.Forms.ToolStripMenuItem.create;
    ViewToolStripMenuItem.Name := 'ViewToolStripMenuItem';
    ViewToolStripMenuItem.Size := System.Drawing.Size.Create(38, 20);
    ViewToolStripMenuItem.Text := '&Вид';
    // NewButton
    NewButton := System.Windows.Forms.ToolStripButton.Create;
    NewButton.Name := 'NewButton';
    NewButton.Size := System.Drawing.Size.Create(64, 22);
    NewButton.Text := 'Кнопа';
    NewButton.DisplayStyle := ToolStripItemDisplayStyle.ImageAndText;
    // Добавление панелей инструментов и элементов меню на область перетаскивания
    DockSite.TopToolStripPanel.Controls.Add(NewMenuStrip);
    DockSite.TopToolStripPanel.Controls.Add(NewToolStrip);
    NewMenuStrip.Items.Add(FileToolStripMenuItem);
    NewMenuStrip.Items.Add(EditToolStripMenuItem);
    NewMenuStrip.Items.Add(ViewToolStripMenuItem);
    FileToolStripMenuItem.DropDownItems.Add(NewToolStripMenuItem);
    NewToolStrip.Items.Add(NewButton);
    // Редактор текста (Editor)
    Editor := System.Windows.Forms.TextBox.Create;
    Editor.Name := 'Editor';
    Editor.TabIndex := 1;
    Editor.Location := System.Drawing.Point.Create(0, 0);
    Editor.Multiline := True;
    Editor.Dock := System.Windows.Forms.DockStyle.Fill;
    Editor.Size := System.Drawing.Size.Create(292, 273);
    Editor.Parent := DockSite.ContentPanel;
    Editor.Visible := True;
    // Добавим иконку
    NewButton.Image := NewButton.Image.FromFile('new.png');
    end;
     

После процедуры конструктора вставьте следующую процедуру. Это будет
обработчиком одной из команд:

    //---------------------------------------------------------------------------
    // Очищаем поле ввода.
    //---------------------------------------------------------------------------
    procedure TWinForm.NewToolStripMenuItem_Click(sender: System.Object;
    e: System.EventArgs);
    begin
    Editor.Clear;
    end;

В регион {\$REGION \'Designer Managed Code\'} класса формы помимо
процедуры InitializeComponent добавьте две строки:\
 \
procedure InitializeComponent;\
procedure NewToolStripMenuItem\_Click(sender: System.Object; e:
System.EventArgs);\

 

Это объявление элемента управления редактора теста, а также процедуры
обработчика клика.\
Как видите, наша форма будет содержать меню, панель управления, 4
команды, одну кнопку на панели управления, а также редактор текста,
который будет очищаться при нажатии на одну из команд меню. В качестве
картинки new.png, которая будет отображаться на кнопке, можете взять
любое изображение размером 16 на 16 пикселей.\
 \

Сохраните файл и, затаив дыхание, запускайте make.bat. В директории с
программой должен появиться скомпилированный файл WinFormsApp.exe

Как видите, приложение прекрасно работает и использует элементы
управления .NET 2.0. С чем всех и поздравляю .\
 \
5.0. Заключение.\
Мы успешно написали и скомпилировали два полноценных .NET 2.0
приложения, используя при этом BDS 4. Этот материал вряд ли понадобится
Вам в жизни по причине сложного процесса разработки, но, Я надеюсь, Вам
было интересно читать эту небольшую статью и Вы не закончите
экспериментировать на этом. В конце концов, написать небольшое
приложение под .NET 2.0 в BDS будет не проблема.\
Думаю надо отдать должное разработчикам BDS 4 за столь продуманный,
пусть и не без ошибок, продукт и надеяться на светлое будущее с Delphi
2007 или Delphi 2008 ![](/pic/embim1918.png){width="288" height="96"}.\
Если у Вас не получилось сделать что-нибудь, что описано в статье,
сообщите мне об этом на мой почтовый адрес (4quadr0\@gmail.com).\
 \
Статья в формате Microsoft Word со всеми исходными кодами:\
http://quadr0.pochta.ru/delphinet2/delphinet2.zip\
 \
Статья в формате Adobe PDF со всеми исходными кодами:\
http://quadr0.pochta.ru/delphinet2/delphinet2\_pdf.zip\

 

С уважением, Титов Сергей (Quadr0).\

 

vingrad.ru\
 \

 

 

 \
 \

 
