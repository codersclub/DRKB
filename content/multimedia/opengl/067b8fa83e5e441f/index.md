---
Title: Экспорт анимированных 3D персонажей из 3D Studio Max 3.0 для Delphi и OpenGL
Date: 01.01.2007
---


Экспорт анимированных 3D персонажей из 3D Studio Max 3.0 для Delphi и OpenGL
============================================================================

::: {.date}
01.01.2007
:::

Введение

В свое время я здорово помучался, решая вопрос - каким же образом
создатели игр ухитряются делать трехмерные персонажи двигающиеся в
реальном времени. Я предположил, что части тела у персонажей отделены от
основного тела, что позволяет независимо поворачивать и перемещать их.
Знаете, в Direct3D даже есть понятие фрейма, фрейм - это основное тело,
к нему прикрепляются другие тела. Когда фрейм движется, прикрепленные к
нему объекты движутся вместе с ним, кроме того, прикрепленные объекты
могут двигаться и самостоятельно не влияя на движение фрейма. Все это
замечательно подходит для создания механических объектов и персонажей,
но совершенно не годится для создания объектов живого мира. Для таких
объектов характерна плавность линий и отсутствие изломов на местах
стыков частей объекта. Создатели компьютерных игр замечательно решили
эту проблему.

Как создается двумерная анимация? Рисуется несколько кадров движения,
затем поледовательно выводятся на экран и таким образом создается
иллюзия движения. То же самое происходит в современных трехмерных
компьютерных играх. Создается несколько 3D моделей (сеток),
характеризующих фазы движения персонажа в различные моменты времени,
затем поледовательно выводятся на экран, создавая иллюзию движения.
Возможно, это приводит к повышенному расходу оперативной памяти,
поскольку все сетки желательно хранить в памяти, но зато значительно
упрощается процесс программирования и, скорее всего, увеличивается
скорость работы приложения.

Следующая проблема возникла при попытке экспорта объектов из 3D Studio
Max в какой-либо открытый формат, например DXF. Нет ничего сложного в
создании трехмерного персонажа с последующей его анимаций, если
пользоваться 3D Studio и Character Studio, вся проблема состоит в том,
как экспортировать объект чтобы потом файл с сетками объекта можно было
использовать в своем приложении. Для этого требуется покадровый экспорт
анимированного персонажа, то есть в итоге должен получится файл,
содержащий несколько сеток объекта изображающих фазы движений объекта в
различные моменты времени, или несколько файлов содержащих одну сетку
соответствующую определенному кадру движения. Однако, несмотря на обилие
поддерживаемых форматов файлов, 3D Studio Max не обладает возможностью
покадрового экспорта трехмерных объектов. Так, напрмер, файл формата 3DS
может хранить информацию о положении объекта, его повороте и масштабе,
но не в состоянии сохранять деформации сетки в различных кадрах
анимации, а именно это нам и нужно. Про файлы формата DXF и ASC даже
говорить в данном случае смешно. Я объясню, почему нам нужно сохранять
именно деформацию сетки. Дело в том, что наш объект должен состоять из
единой, цельной сетки, а не из нескольких объектов, чтобы не было стыков
на местах соединений конечностей с телом. Создать анимацию, так чтобы
персонаж мог двигать своими конечностями, в этом случае, можно только
деформируя сетку, а именно перемещая одни вершины сетки относительно
других. Так, например, чтобы персонаж поднял руку нужно переместить
вершины руки вверх относительно вершин тела. Теперь, я надеюсь, все
понятно? Итак, оказалось, что 3DStudio не в состоянии сохранить подобную
анимацию. Однако, не все так печально. Например, есть такой
дополнительный модуль для 3DStudio, называется Bones Pro Max, а у него
есть инструмент SnapShot, который позволяет делать снимки различных
кадров движения объекта. В результате его работы у Вас на рабочем поле
3D Studio Max появляется целое стадо одинаковых трехмерных объектов в
различных позах. Правду сказать, я его не нашел, да и выпущен он был уже
давно еще под первую версию 3D Studio Max. Поэтому я решил идти другим
путем и окунулся во внутренний язык 3D Studi Max - Max Script.
Результатом моей деятельности стала простенькая утилита Meshes Export
for Games and Animation (MEGA), которая позволяет делать все, о чем я
сказал выше и некоторые другие полезные вещи.

Знакомство с утилитой MEGA V 1.0

Для ознакомления с этой утилитой Вам понадобится графический пакет 3D
Studio Max 3.0 и, собственно, сама утилита. Она расположена в папке
Utility и называется MEGA.ms. Это не исполняемый файл, а текстовый файл
с набором команд для 3D Studio Max написанных на языке Max Script.

Запустите 3D Studio Max и создайте простой объект - сферу. Я полагаю,
что даже те, кто никогда не видел этого графического редактора, без
труда справятся с таким простым заданием.

Теперь, щелкайте на сфере правoй кнопкой мыши пока не появится
контекстное меню. Как правило, с первого раза оно не появляется. В
контекстном меню выберите строку Convert to Editable Mesh (Преобразовать
в Редактируемую Сетку). Обратите внимание: объект, непременно, должен
быть Редактируемой Сеткой, если в выходном файле мы хотим получить
список вершин и граней, иначе мы получим имя объекта и его свойства,
такие как, радиус, количество сегментов - для сферы, высоту, ширину и
глубину - для параллелепипеда и т.д.

Перейдите на командную панель (она расположена справа) и выберите
вкладку с изображением молотка. Это вкладка утилит. Нажмите кнопку
MAXScript, внизу панели развернется свиток MAXScript\'a. Нажмите кнопку
Запуск Макроса, появится диалоговое окно открытия файла. Запустите файл
MEGA.ms. Внизу командной панели в списке утилит должна появится надпись
MEGA, однако это еще не означает, что утилита уже запущена. Чтобы ее
запустить, необходимо раскрыть спиок утилит и выделить строку MEGA.
Внизу панели должен раскрыться свиток MEGA.

Введите в поле From зачение 1, в поле To - 100, в поле Step - 100.
Нажмите кнопку Save As\..., в диалоговом окне введите имя файла, куда
бдете сохранять и нажмите кнопку сохранить. Объект экспортирован в файл
с расширением GMS.

Как работает утилита: При экспорте файла, берется значение из поля From
и ползунок счетчика кадров расположенный внизу экрана премещается на
позицию, соответствующую этому значению. Затем в выходной файл
экспортируется объект в том виде, в каком он пребывает на данный момент
на экране. После чего снова передвигается ползунок кадров на величину,
введенную в поле Step. Снова записывается модель соответствующая этому
кадру. И так до тех пор, пока ползунок не переместится на позицию
соответствующую значению, введенному в поле To. Поскольку в данном
примере мы не создавали анимацию, то нам нужен был только один кадр.
Утилита экспортировала кадр №1, затем добавила к нему значение 100.
Номер кадра стал равен 101. Поскольку это значение больше значения
введенного в поле To, процесс экспорта на этом остановился. Если бы в
поле From было введено значение 0, то было бы экспортировано 2 кадра с
номерами 0 и 100 соответственно. Если пометить галочкой опцию Selected
Only, то экспортироваться будут только выделенные объекты, это иногда
бывает очень нужно, в противном случае будут экспортированы все объекты
сцены. Теперь рекомендую рассмотреть формат файла GMS.

Формат файла GMS

Файл GMS это текстовый файл открытого формата, что означает, что даже
человек не знакомый с его описанием может создать приложение,
считывающее из него информацию. Тем не менее, приведу на всякий случай
описание этого файла.

// Указывает на начало нового объекта,

// следующая строка указывает тип объекта

New object

TriMesh() // Объект - сетка

   // Указывает, что следующая строка содержит количество

   // вершин и граней для данного объекта

   numverts numfaces

   Mesh vertices:

   // Здесь располагается блок вершин объекта в виде координат X Y Z

   end vertices

   Mesh faces:

   // Здесь располагается блок граней объекта в виде индексов 1 2 3,

   // где каждый индекс - индекс в массиве вершин, указывает на вершину
грани

   end faces

   Faset normals:

   // Здесь располагается блок фасетных нормалей в виде координат X Y Z.

   // Их количество равно количеству граней

   end faset normals

   Smooth normals:

   // Здесь располагается блок сглаживающих нормалей в виде координат X
Y Z.

   // Их количество равно количеству вершин.

   end smooth normals

end mesh  // Конец описания объекта Tri Mesh

end of file // Конец файла

Примерно так выглядит файл, когда мы экспортируем сетчатый объект. Если
объект не сетчатый, то файл будет выглядеть следующим образом:

// Указывает на начало нового объекта,

// следующая строка указывает тип объекта

New object

\<Тип объекта\>, например: Box

// Здесь идут параметры, зависящие от типа объекта

// (Поверхности Безье и NURBS - поверхности не поддерживаются)

end \<Тип объекта\> // Конец описания объекта

end of file // Конец файла

Загрузка файла формата GMS в Delphi

Пример загрузки файла GMS находится в папке Ch01. В проекте присутствует
два модуля: frmMain.pas и Mesh.pas. Откомпилировав и запустив проект на
выполнение вы должны увидеть вращающийся Тор (по-нашему: \"Баранка\").
Несмотря на то, что объект можно считать стандартным, он был в 3D Studio
преобразован в сетку, поэтому в данном случае это именно сетчатый
объект. Нажав пункт меню \"загрузить\", вы можете посмотреть любой
объект из папки GMS или загрузить свою сферу, которую сделали сами, если
правильно руководствовались моими инструкциями в разделе: Знакомство с
утилитой MEGA V1.0. Теперь рассмотрим данный пример подробно. Почти весь
код модуля frmMain.pas написан не мной. Он взят из книги \"OpenGL
графика в проектах Delphi\" Михаила Краснова. Этот модуль выполняет
инициализацию приложения и циклическую функцию отрисовки окна, поэтому
подробно мы его рассматривать не будем. Если код покажется Вам
непонятным, значит Вы недостаточно знакомы с OpenGL, в этом случае Вам
надлежит обратится к первоисточнику (в смысле - к книге). Код модуля
Mesh.pas выполняет загрузку данных из файла и отображение объектов в
окне. Рассмотрим его подробнее:

    // Объявление типов данных
    type
      // Указатель на вершину
      PGLVertex = ^TGLVertex;
      TGLVertex = record
        // Вершина, как три значения с плавающей точкой
        x, y, z: GLFloat;
      end;
      // Указатель на вектор
      PGLVector = ^TGLVector;
      // Вектор, как массив из трех элементов с плавающей точкой
      TGLVector = array[0..2] of GLFloat;
      // Указатель на грань
      PGLFace = ^TGLFace;
      // Грань, как массив из трех целочисленных значений
      TGLFace = array[0..2] of GLInt;
      // Указатель на массив вершин
      PGLVertexArray = ^TGLVertexArray;
      // Массив вершин
      TGLVertexArray = array[Word] of TGLVertex;
      // Указатель на массив граней
      PGLFacesArray = ^TGLFacesArray;
      // Массив граней
      TGLFacesArray = array[word] of TGLFace;

Здесь требуется небольшое пояснение. Как вы заметили, грань объявлена,
как массив из трех целочисленных чисел. Дело в том, что граней почти
всегда больше чем вершин. Поэтому все вершины запоминаются в отдельном
массиве, а грань - это три индекса в этом массиве, указывающие на
вершины принадлежащие грани. Одна вершина может принадлежать нескольким
граням.

Теперь рассмотрим описание объекта сетка:

    TGLMesh = class
      // Массив вершин объекта - сетка
      Vertices : PGLVertexArray;
      // Массив граней
      Faces : PGLFacesArray;
      // Массив фасетных нормалей
      FasetNormals : PGLVertexArray;
      // Количество вершин
      VertexCount : Integer;
      // Количество граней
      FacesCount : Integer;
      // Коэффициент масштабирования
      fExtent : GLFloat;
      // Флаг масштабирования
      Extent : GLBoolean;
    public
      // Загрузка
      procedure LoadFromFile(const FileName: string);
      // Расчет нормалей
      procedure CalcNormals;
      // Отрисовка
      procedure Draw;
      // Уничтожение с очисткой массивов
      destructor Destroy; override;
    end;

Здесь пояснений практически не требуется. Можно лишь отметить, что
Extent служит для того, чтобы объект загнать в размеры в пределах (-1,
1), я сделал это для того, чтобы объект любого размера не мог вылезти за
пределы окна. Вообще говоря, в 3D Studio Max не сложно масштабировать
объект так, чтобы координаты вершин попали в интервал (-1, 1), но на
этапе создания модели думать об этом совсем не хочется.

    // Загрузка файла
    procedure TGLMesh.LoadFromFile;
    var
      f : TextFile;
      S : string;
      i : Integer;
      Vertex : TGLVertex;
      Face : TGLFace;
      MaxVertex : GLFloat;
    begin
     
      AssignFile(f,FileName);
      Reset(f);
      // Пропускаем строки, пока не попадется 'numverts numfaces'
      repeat
        ReadLn(f, S);
      until
        (S = 'numverts numfaces') or eof(f);
     
      // Читаем количество вершин и граней
      Readln(f,VertexCount,FacesCount);
     
      // Выделяем память для хранения сетки
      GetMem(Vertices,VertexCount*SizeOf(TGLVertex));
      GetMem(Faces,FacesCount*SizeOf(TGLFace));
      GetMem(FasetNormals,FacesCount*SizeOf(TGLVector));
     
      // Пропускаем строку "Mesh vertices"
      ReadLn(f, S);
     
      // Считываем вершины
      for i := 0 to VertexCount - 1 do
      begin
        Readln(f,Vertex.x,Vertex.y,Vertex.z);
        Vertices[i] := Vertex;
      end;
     
      // Пропускаем строку "end vertices"
      ReadLn(f, S);
      // Пропускаем строку "Mesh faces"
      ReadLn(f, S);
     
      // Считываем грани
      for i := 0 to FacesCount - 1 do
      begin
        Readln(f,Face[0],Face[1],Face[2]);
        Face[0] := Face[0] - 1;
        Face[1] := Face[1] - 1;
        Face[2] := Face[2] - 1;
        Faces[i] := Face;
      end;
     
      CloseFile(f);
     
      // Рассчитываем масштаб
      MaxVertex := 0;
     
      for i := 0 to VertexCount - 1 do
      begin
        MaxVertex := Max(MaxVertex,Vertices[i].x);
        MaxVertex := Max(MaxVertex,Vertices[i].y);
        MaxVertex := Max(MaxVertex,Vertices[i].z);
      end;
     
      fExtent := 1/MaxVertex;
      CalcNormals;
    end;

Здесь могут быть непонятны следующие моменты: В блоке считывания граней
я вычитаю единицу из каждого индекса вершины, считанного из файла.
Делается это потому, что в программе индексы нумеруются, начиная с нуля,
а в файле GMS - начиная с единицы. Процедура CalcNormals служит для
расчета нормалей и взята из книги \"OpenGL графика в проектах Delphi\"
Михаила Краснова. О том, что такое нормали и зачем они нужны я расскажу
в разделах \"Фасетные нормали\" и \"Сглаживающие нормали\".

    procedure TGLMesh.Draw;
    var
      i : Integer;
      Face : TGLFace;
    begin
      if Extent then
        glScalef(fExtent,fExtent,fExtent);
     
      for i := 0 to FacesCount - 1 do
      begin
        glBegin(GL_TRIANGLES);
        Face := Faces[i];
        glNormal3fv(@FasetNormals[i]);
        glVertex3fv(@Vertices[Face[0]]);
        glVertex3fv(@Vertices[Face[1]]);
        glVertex3fv(@Vertices[Face[2]]);
        glEnd;
      end;
    end;

Здесь все понятно. Сначала, если установлен флаг масштабирования,
устанавливается масштаб одинаковый по всем осям, затем в цикле рисуются
треугольники. Перед началом рисования треугольника объявляется нормаль к
нему. В качестве параметров передаются не конкретные значения, а
указатели на них.

    destructor TGLMesh.Destroy;
    begin
      FreeMem(Vertices,VertexCount*SizeOf(TGLVertex));
      FreeMem(Faces,FacesCount*SizeOf(TGLFace));
      FreeMem(FasetNormals,FacesCount*SizeOf(TGLVector));
    end;

Здесь тоже все понятно, просто освобождается память, занятая объектом.
Вызовы процедур загрузки и отрисовки объекта находятся в модуле frmMain
и не представляют ничего интересного.

Создание анимированного персонажа и вывод на экран

Специально для тех, кто не владеет навыками работы с 3D Studio Max и
Character Studio, я создал модель бегающего человечка. Она находится в
папке MAX, и файл называется BodyRun.max. Если у Вас вообще нет пакета
3D Studio Max, то файл GMS с сетками этого человечка находится в папке
GMS и называется ManRun.gms.

Итак, запустите среду 3D Studio Max и создайте анимированного персонажа
или загрузите его из файла BodyRun.max. Запустите утилиту MEGA, как это
делалось в разделе Знакомство с утилитой MEGA V1.0. Установите значение
поля From =0, значение поля To установите в кадр, на котором
заканчивается анимация, в случае с файлом BodyRun.max это значение нужно
установить в 11. Значение поля Step установите в еденицу. Выделите сетку
персонажа.

Внимание:

убедитесь, что Вы выделили именно сетку персонажа и только ее. Пометьте
флажок Selected Only. Для анимации сетки используется скелет. Он
создается и подгоняется под размеры и форму тела, затем вершины сетки
связываются с костями скелета. При анимации изменяются параметры
положения частей скелета, а сетка лишь следует за ними. Поэтому, всегда,
когда используется этот подход, в сцене помимо сетки присутствует
скелет. Вот почему необходимо выделить только сетку и пометить флажок
Selected Only.

После того, как Вы выполнили все операции укзанные выше, экспортируйте
объект в файл GMS. В процессе экспорта Вы должны увидеть, как
последовательно перемещается ползунок расположенный внизу экрана,
отсчитывая кадры анимации, и как меняются кадры в проекционных окнах 3D
Studio Max. Процесс экспорта завершится, когда ползунок достигнет
конечного значения.

Готовый проект лежит в папке Ch02. Откомпилируйте его и запустите на
выполнение. Нажатием кнопки \"Анимировать\" можно запускать или
останавливать анимацию. Если Ваш компьютер оснащен 3D ускорителем, то
лучше развернуть окно на весь экран - так медленнее. Теперь разберем
исходный код программы. Он дополнился новым объектом TGLMultyMesh,
который создан для загрузки и последовательной отрисовки нескольких
сетчатых объектов.

    TGLMultyMesh = class
        Meshes : TList;
        CurrentFrame : Integer;
        Action : Boolean;
        fExtent : GLFloat;
        Extent : Boolean;
      public
        procedure LoadFromFile(const FileName: string);
        procedure Draw;
        constructor Create;
        destructor Destroy; override;
      published
    end;

Список Meshes хранит все сетки загруженные из файла. Переменная Action
указывает выполняется анимация или нет, а CurrentFrame содержит номер
текущего кадра анимации.

    procedure TGLMultyMesh.LoadFromFile;
    var
      f : TextFile;
      S : string;
     
      procedure ReadNextMesh;
      var
        i : Integer;
        Vertex : TGLVertex;
        Face : TGLFace;
        MaxVertex : GLFloat;
        NextMesh : TGLMesh;
      begin
        NextMesh := TGLMesh.Create;
        repeat
          ReadLn(f, S);
        until
          (S = 'numverts numfaces') or eof(f);
        // Читаем количество вершин и граней
        Readln(f,NextMesh.VertexCount,NextMesh.FacesCount);
        // Выделяем память для хранения сетки
        GetMem(NextMesh.Vertices,NextMesh.VertexCount*SizeOf(TGLVertex));
        GetMem(NextMesh.Faces,NextMesh.FacesCount*SizeOf(TGLFace));
        GetMem(NextMesh.FasetNormals,NextMesh.FacesCount*SizeOf(TGLVector));
        ReadLn(f,S); // Пропускаем строку Mesh vertices:
        // Считываем вершины
        for i := 0 to NextMesh.VertexCount - 1 do
        begin
          Readln(f,Vertex.x,Vertex.y,Vertex.z);
          NextMesh.Vertices[i] := Vertex;
        end;
        ReadLn(f,S); // Пропускаем строку end vertices
        ReadLn(f,S); // Пропускаем строку Mesh faces:
        // Считываем грани
        for i := 0 to NextMesh.FacesCount - 1 do
        begin
          Readln(f,Face[0],Face[1],Face[2]);
          Face[0] := Face[0] - 1;
          Face[1] := Face[1] - 1;
          Face[2] := Face[2] - 1;
          NextMesh.Faces[i] := Face;
        end;
        // Рассчитываем масштаб
        MaxVertex := 0;
        for i := 0 to NextMesh.VertexCount - 1 do
        begin
          MaxVertex := Max(MaxVertex,NextMesh.Vertices[i].x);
          MaxVertex := Max(MaxVertex,NextMesh.Vertices[i].y);
          MaxVertex := Max(MaxVertex,NextMesh.Vertices[i].z);
        end;
        NextMesh.fExtent := 1/MaxVertex;
        NextMesh.CalcNormals;
        Meshes.Add(NextMesh);
      end;
     
    begin
      Meshes := TList.Create;
      AssignFile(f,FileName);
      Reset(f);
      while not Eof(f) do
      begin
        Readln(f,S);
        if S = 'New object' then
          ReadNextMesh;
      end;
      CloseFile(f);
    end;

Код загрузки объекта TGLMultyMesh практически идентичен коду загрузки
объекта TGLMesh. Небольшое отличие состоит в том, что объект
TGLMultyMesh предполагает, что файл содержит несколько сеток. Поэтому
при загрузке проиходит поиск строки \"New Object\", создается объект
TGLMesh, который помещается в список Meshes и в него считывается
информация из файла. Затем весь цикл повторяется до тех пор, пока не
кончится файл. Процедуры создания, уничтожения и отрисовки объекта тоже
почти не изменились:

    procedure TGLMultyMesh.Draw;
    begin
      if Extent then
      begin
        fExtent := TGLMesh(Meshes.Items[CurrentFrame]).fExtent;
        glScalef(fExtent,fExtent,fExtent);
      end;
      // Рисование текущего кадра
      TGLMesh(Meshes.Items[CurrentFrame]).Draw;
      // Если включена анимация увеличить значение текущего кадра
      if Action then
      begin
        inc(CurrentFrame);
        if CurrentFrame > (Meshes.Count - 1) then
          CurrentFrame := 0;
      end;
    end;
     
    constructor TGLMultyMesh.Create;
    begin
      Action := False;
      CurrentFrame := 0;
    end;
     
    destructor TGLMultyMesh.Destroy;
    var
      i : Integer;
    begin
      for i := 0 to Meshes.Count - 1 do
        TGLMesh(Meshes.Items[i]).Destroy;
      Meshes.Free;
    end;

Немного изменился и вызов функции загрузки в модуле frmMain.pas.

    procedure TfrmGL.N1Click(Sender: TObject);
    begin
      if OpenDialog.Execute then
      begin
        MyMesh.Destroy;
        Mymesh := TGLMultyMesh.Create;
        MyMesh.LoadFromFile( OpenDialog.FileName );
        MyMesh.Extent := true;
        // Проверяем сколько сеток загружено и возможна ли анимация
        if MyMesh.Meshes.Count <= 1 then
          N2.Enabled := False
        else
          N2.Enabled := True;
      end;
    end;
     
    // Включение анимации
    procedure TfrmGL.N2Click(Sender: TObject);
    begin
      MyMesh.Action := not MyMesh.Action;
      N2.Checked := not N2.Checked;
    end;

Здесь все должно быть предельно ясно, не будем акцентировать на этом
внимание, и так статья длиннее получается, чем я расчитывал.

Да, конечно, человечек убогий. Мало того, что он кривой, так еще и
прихрамывает. Что делать, чтобы создавать красивых человечков с
минимальным количеством граней нужно быть профессионалом 3D
моделирования. Все же, мы еще попытаемся его улучшить.

Вероятно, Вы заметили, огрехи воспроизведения объектов на экране,
выражающиеся в каких - то непонятных черных треугольниках в тех местах,
где их не должно быть. Сам я понятия не имею, откуда они взялись. Если
Вас не удовлетворяет такой вид объектов, значит, настала пора поговорить
о нормалях.

Что такое нормали

Нормалью называется перпендикуляр к чему-либо. В нашем случае это
перпендикуляр к грани. Хотелось бы, но, к сожалению, без нормалей никак
не обойтись. Дело в том, что по нормалям расчитывается освещение
объекта. Так, например, если нормаль грани направлена на источник света,
то грань будет освещена максимально. Чем больше нормаль отвернется от
источника света, тем менее грань будет освещена. В случае с OpenGL, если
нормаль отвернется от экрана более чем на 90 градусов, мы вообще не
увидим грань, она не будет отрисовываться. Если бы мы не использовали
нормали, то наш объект был бы закрашен одним цветом, то есть мы бы
увидели только силует объекта. Трехмерный эффект достигается
окрашиванием граней объекта в разные по яркости цвета, или наложением
теней, кому как больше нравится это называть. Кроме того, степень
освещенности зависит также от длины вектора нормали, но, как правило,
длина вектора нормали должна находится в пределах (0; 1).

Теперь я думаю, стало ясно, что такое нормали и зачем они нужны.

Загрузка фасетных нормалей из файла GMS

Что такое фасетная нормаль? Фасетная нормаль, это самая обычная нормаль
к грани, а называется она так по производимому воздействию на
изображаемый объект. После применения фасетных нормалей грани объекты
хоть и освещены по-разному, но каждая грань освещена равномерно и
соответственно закрашена одним цветом, что приводит к тому, что объект
выглядит граненым. Отсюда и название. По-нашему \"фасетная нормаль\" это
\"граненая нормaль\". В предыдущих примерах фасетные нормали
рассчитывались по математическому алгоритму (процедура CalcNormals), но
по всей видимости он иногда дает сбои. Не все то хорошо для
программиста, что хорошо для математика. В результате и появляются
черные треугольники там где их не должно быть.

К счастью, внутренний язык 3D Studio Max позволил мне найти фасетные
нормали, которые он использовал для отображения объекта, а отображались
объекты в 3D Studio Max правильно. Приложение, использующее нормали,
взятые из 3D Studio Max, находится в папке Ch03. А какая при этом
получается разница, Вы можете увидеть на картинках ниже:

Теперь наша баранка выглядит правильно. В процедуре загрузки сетки
добавился блок считывания фасетных нормалей из файла GMS. Процедуру
CalcNormals я оставил в исходном тексте, но закоментировал.

    ReadLn(f, S); //Пропускаем строку "end faces"
    ReadLn(f, S); // Пропускаем строку "Faset normals"
     
    // фасетные нормали
    for i := 0 to FacesCount - 1 do
    begin
      Readln(f,Normal.x,Normal.y,Normal.z);
      FasetNormals[i] := Normal;
    end;

Естественно, что количество фасетных нормалей равняется количеству
граней.

Загрузка сглаживающих нормалей из файла GMS

Все-таки, несмотря на то, что объект теперь отображается правильно,
хочется чего-то еще. Ну кому понравится граненая баранка? Или футбольный
мяч такой, будто его вытесали из гранита? И, несмотря на то, что уровень
детализации в данном примере не высок, можно еще улучшить внешний вид
объекта. На помощь приходят сглаживающие нормали. Об этом стоит
рассказать подробнее.

Когда я понял, что, используя команду glShadeModel, мне не удастся
сгладить мой объект (и у Вас не получится тоже), я затосковал. Нужно
было что-то делать, и я решил заняться этим вопросом вплотную. Вот что
мне удалось выяснить. Оказывается к одной грани можно построить не одну
нормаль, а столько, сколько душа пожелает. Но это еще ничего не дает. А
вот если мы нормаль отклоним в сторону, так что она станет, не
перпендикулярна грани, то грань окрасится неравномерно. Конечно, слова о
том, что \"нормаль не перпендикулярна\", могут показаться немного
странными для математика, но программиста это смущать не должно :). Я
попробую пояснить подробнее, что же получается в этом случае.

Взгляните на них. Мы имеем четырехугольную грань, в каждом углу которой
построена нормаль. Все нормали перпендикулярны грани, и грань выглядит
плоской. Нормали разведены в стороны от центра грани и грань освещена
неравномерно, так будто она выпукла, хотя на самом деле она плоская.
Если же свести нормали к центру грани, то грань станет вогнутой.

Это можно применять следующим образом. Чтобы добиться эффекта
сглаживания, строить нормали нужно к вершинам грани, на каждую вершину
по одной нормали. Для построения нормали, необходимо узнать к каким
граням принадлежит вершина (теоретически вершина может принадлежать
бесконечному числу граней - на практике не больше 12), взять фасетные
нормали от этих граней, расчитать от них среднюю нормаль и построить ее
к вершине. Как это сделать? Какими формулами это считается? Честно
говоря, я понятия не имею. Есть такой сайт: http://www.pobox.com/\~nate
Ната Робинсона, там лежит пример на сглаживание и не только. Правда,
написан он на Сях. Мне бы не составило труда переписать его на Дельфи,
но\... Зачем утруждать себя, если есть Баунти? Снова берем 3D Studio
Max, лезем внутрь, хватаем сглаживающие нормали и\... Вуаля!

Проект находится в папке Ch04. Скомпилируйте его и запустите на
выполнение. Теперь Вы можете наслаждаться внешним видом сглаженного
бублика нажав на кнопку Фасеты/Сгладить. Выглядит это примерно так:

Код программы, как всегда существенно не изменился. В процедуру загрузки
добавился блок загрузки сглаживающих нормалей:

     
    ReadLn(f,S); // Пропускаем строку end faset normals
    ReadLn(f,S); // Пропускаем строку SmoothNormals:
     
    // Считываем сглаживающие нормали
    for i := 0 to NextMesh.VertexCount - 1 do
    begin
      Readln(f,Normal.x,Normal.y,Normal.z);
      NextMesh.SmoothNormals[i] := Normal;
    end;

Процедура отрисовки претерпела \"существенные\" изменения:

    procedure TGLMesh.Draw(Smooth: Boolean);
    var
      i : Integer;
      Face : TGLFace;
    begin
      for i := 0 to FacesCount - 1 do
      begin
        glBegin(GL_TRIANGLES);
        Face := Faces[i];
        if Smooth then
        begin
          // Если сглаживать тогда перед каждой
          glNormal3fv(@SmoothNormals[Face[0]]);
          // вершиной рисуем сглаживающую нормаль
          glVertex3fv(@Vertices[Face[0]]);
          glNormal3fv(@SmoothNormals[Face[1]]);
          glVertex3fv(@Vertices[Face[1]]);
          glNormal3fv(@SmoothNormals[Face[2]]);
          glVertex3fv(@Vertices[Face[2]]);
        end
        else
        // Если не сглаживать один раз рисуем фасетную нормаль
        begin
          glNormal3fv(@FasetNormals[i]);
          glVertex3fv(@Vertices[Face[0]]);
          glVertex3fv(@Vertices[Face[1]]);
          glVertex3fv(@Vertices[Face[2]]);
        end;
        glEnd;
      end;
    end;
     
    procedure TGLMultyMesh.Draw;
    begin
      if Extent then
      begin
        fExtent := TGLMesh(Meshes.Items[CurrentFrame]).fExtent;
        glScalef(fExtent,fExtent,fExtent);
      end;
      TGLMesh(Meshes.Items[CurrentFrame]).Draw(fSmooth);
      if Action then
      begin
        inc(CurrentFrame);
        if CurrentFrame > (Meshes.Count - 1) then
          CurrentFrame := 0;
      end;
    end;

Сам объект TGLMesh дополнился массивом для сглаживающих нормалей, а
TGLMultyMesh - флагом указывающим следует ли сглаживать или нет. Этот
флаг передается в процедуру отрисовки объекта TGLMesh. Деструктор
пополнился строкой уничтожающей массив сглаживающих нормалей. В модуле
frmMain появился обработчик нажатия пункта меню Фасеты/Сгладить.

Вот, пожалуй, и все. Могу только добавить, что не всегда удобно
пользоваться сглаживающими нормалями из файла GMS, хотя в большинстве
случаев они подходят. Загрузите, к примеру, объект Zban.gms и установите
сглаживающий режим. Видите, все сглажено, а в 3D Studio Max он выглядел
по-другому. Сверху и снизу у него были полукруглые крышки, но посередине
был четкий цилиндр, с резкой границей в местах состыковки с полукруглыми
крышками. Это побочный эффект сглаживания. Если Вы хотите добится
исчезновения этого эффекта, Вам придется написать приложение для ручной
корректировки нормалей, или программно отслеживать ситуацию, когда излом
достиг критического угла и следует воспользоваться фасетной нормалью.
Теперь, пожалуй, действительно все.

Взято с <https://delphiworld.narod.ru>