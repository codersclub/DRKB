---
Title: О таймере
Date: 01.01.2007
Source: http://www.delphi.h5.ru/
---


О таймере
=========

Компонент timer (таймер) служит для отсчета интервалов реального
времени. Его свойство interval определяет интервал временив
миллисекундах, который должен пройти от включения таймера до
наступления события ontimer. Таймер включается при установке значения
true в его свойство enabled. Единожды включенный таймер все время будет
возбуждать события ontimer до тех пор, пока его свойство enabled не
примет значения false.

Следует учесть, что в силу специфики реализации стандартного аппаратного
таймера ibm-совместимого компьютера минимальный реально достижимый
интервал отсчета времени не может быть меньше 55 мс (этот интервал
называется тиком), более того, любой интервал времени, отсчитываемый с
помощью таймера, всегда кратен 55 мс. Чтобы убедиться в этом, проведите
эксперимент, в котором подсчитывается среднее время между двумя
срабатываниями таймера (timer.dpr):

Начните новый проект с пустой формой и положите на нее компонент
ttimer.
Установите в свойство enabled таймера значение false.
Напишите такой модуль главной формы (листинг 4):

Листинг 4

    unit unit1; 
     
    interface 
     
    uses 
    windows, messages, sysutils, classes, graphics, controls, forms, 
    dialogs, stdctrls, buttons, extctrls; 
     
    type 
      tfmexample = class(tform) 
      panel1: tpanel; 
      bbrun: tbitbtn; 
      bbclose: tbitbtn; 
      edinput: tedit; 
      lboutput: tlabel; 
      mmoutput: tmemo; 
      timer1: ttimer; 
      procedure bbrunclick(sender: tobject); 
      procedure timer1timer(sender: tobject); 
      procedure formactivate(sender: tobject); 
      private 
      begtime: tdatetime; // Начальное время цикла 
      counter: integer; // Счетчик цикла 
    end; 
     
    var fmexample: tfmexample; 
     
    implementation 
     
    {$r *.dfm} 
     
    procedure tfmexample.bbrunclick(sender: tobject); 
    // Запускает таймер. edinput содержит период его срабатывания. 
    var delay: word; 
    begin 
      // Проверяем задание интервала 
      if edinput.text='' then exit; 
      try 
        delay := strtoint(edinput.text); 
      except 
        showmessage('Ошибка в записи числа'); 
        edinput.selectall; 
        edinput.setfocus; 
        exit 
      end; 
      counter := 0; // Сбрасываем счетчик 
      timer1.interval := delay; // Устанавливаем интервал 
      begtime := time; // Засекаем время 
      timer1.enabled := true; // Пускаем таймер 
      screen.cursor := crhourglass 
    end; 
     
    procedure tfmexample.timer1timer(sender: tobject); 
      var h, m, s, ms: word; // Переменные для декодирования времени 
      const maxcount = 55; // Количество срабатываний таймера 
    begin 
      counter := counter + 1; // Наращиваем счетчик срабатываний 
      if counter=maxcount then // Конец цикла? 
      begin // - Да 
        timer1.enabled := false; // Останавливаем таймер 
        // Находим среднее время срабатывания: 
        decodetime((time-begtime)/maxcount, h, m, s, ms); 
        mmoutput.lines.add( // Выводим результат 
        format('Задано %s ms. Получено %d ms.', [edinput.text, ms])); 
        edinput.text := ''; // Готовим следующий запуск 
        edinput.setfocus; 
        screen.cursor := crdefault 
      end; 
    end; 
     
    procedure tfmexample.formactivate(sender: tobject); 
    begin 
      edinput.setfocus 
    end; 
     
    end. 

Необходимость нескольких (maxcount) срабатываний для точного усреднения
результата связана с тем, что системные часы обновляются каждые 55 мс.
После запуска программы и ввода 1 как требуемого периода срабатывания в
редакторе mmoutput вы увидите строку

    Задано 1 ms. Получено 55 ms.

в которой указывается, какое реальное время разделяет два соседних
события ontimer. Если вы установите период таймера в диапазоне от 56 до
110 мс, в строке будет указано 110 ms и т.д. (в силу дискретности
обновления системных часов результаты могут несколько отличаться в ту
или иную сторону).

В ряде практически важных областей применения (при разработке игр, в
системах реального времени для управления внешними устройствам и т.п.)
интервал 55 мс может оказаться слишком велик. Современный ПК имеет
мультимедийный таймер, период срабатывания которого может быть от 1 мс и
выше, однако этот таймер не имеет компонентного воплощения, поэтому для
доступа к нему приходится использовать функции api.

Общая схема его использования такова. Сначала готовится процедура
обратного вызова (call back) с заголовком:

    procedure timeproc(uid, umsg: uint; dwuser, dw1, dw2: dword); stdcall; 

Здесь uid - идентификатор события таймера (см. об этом ниже);  
umsg - не используется;  
dwuser - произвольное число, передаваемое процедуре в момент срабатывания таймера;  
dw1, dw2 - не используются.

Запуск таймера реализуется функцией:

    function timesetevent(udelay, uresolution: uint;
                          lptimeproc: pointer;
                          dwuser: dword;
                          fuevent: uint): uint; stdcall; external 'winmm.dll'; 


Здесь udelay - необходимый период срабатывания таймера (в мс);  
uresolution - разрешение таймера (значение 0 означает, что события
срабатывания таймера будут возникать с максимально возможной частотой; в
целях снижения нагрузки на систему вы можете увеличить это значение);  
lptimeproc - адрес процедуры обратного вызова;  
dwuser - произвольное число, которое передается процедуре обратного вызова
и которым программист может распоряжаться по своему усмотрению;  
fuevent - параметр, управляющий периодичностью возникновения события таймера:
time\_oneshot (0) - событие возникает только один раз через udelay
миллисекунд;  
time\_periodic (1) - события возникают периодически
каждые udelay мс.

При успешном обращении функция возвращает
идентификатор события таймера или 0, если обращение было ошибочным.

Таймер останавливается, и связанные с ним системные ресурсы
освобождаются функцией:

    function timekillevent(uid: uint): uint; stdcall; external 'winmm.dll'; 

Здесь uid - идентификатор события таймера, полученный с помощью
timesetevent.

В следующем примере (timer.dpr) иллюстрируется использование
мультимедийного таймера (листинг 5).

    unit unit1; 
     
    interface 
     
    uses 
    windows, messages, sysutils, classes, graphics, controls, forms, 
    dialogs, stdctrls, buttons, extctrls; 
     
    type 
      tfmexample = class(tform) 
      panel1: tpanel; 
      bbrun: tbitbtn; 
      bbclose: tbitbtn; 
      edinput: tedit; 
      lboutput: tlabel; 
      mmoutput: tmemo; 
      procedure bbrunclick(sender: tobject); 
      procedure formactivate(sender: tobject); 
    end; 
     
    var fmexample: tfmexample; 
     
    implementation 
     
    {$r *.dfm} 
    // Объявление экспортируемых функций: 
     
    function timesetevent(udelay, ureolution: uint; lptimeproc: pointer; 
    dwuser: dword; fuevent: uint): integer; stdcall; external 'winmm'; 
     
    function timekillevent(uid: uint): integer; stdcall; external 'winmm'; 
     
    // Объявление глобальных переменных 
    var 
      ueventid: uint; // Идентификатор события таймера 
      begtime: tdatetime; // Засекаем время< 
      counter: integer; // Счетчик повторений 
      delay: word; // Период срабатывания 
     
    procedure proctime(uid, msg: uint; dwuse, dw1, dw2: dword); stdcall; 
    // Реакция на срабатывание таймера (процедура обратного вызова) 
    var h, m, s, ms: word; // Переменные для декодирования времени 
    const maxcount = 55; // Количество повторений 
    begin 
      timekillevent(ueventid); // Останавливаем таймер 
      counter := counter+1; // Наращиваем счетчик 
      if counter=maxcount then // Конец цикла? 
      begin // - Да: декодируем время 
        decodetime((time-begtime)/maxcount, h, m, s, ms); 
        fmexample.mmoutput.lines.add( // Сообщаем результат 
        format('Задано %s ms. Получено %d ms', 
        [fmexample.edinput.text,ms])); 
        fmexample.edinput.text := ''; // Готовим повторение 
        fmexample.edinput.setfocus 
      end 
      else // - Нет: вновь пускаем таймер 
        ueventid := timesetevent(delay,0,@proctime,0,1); 
    end; 
     
    procedure tfmexample.bbrunclick(sender: tobject); 
    // Запускает таймер. edinput содержит требуемый период. 
    begin 
      // Проверяем задание периода 
      if edinput.text='' then exit; 
      try 
        delay := strtoint(edinput.text) 
      except 
        showmessage('Ошибка ввода числа'); 
        edinput.selectall; 
        edinput.setfocus; 
        exit 
      end; 
      counter := 0; // Сбрасываем счетчик 
      begtime := time; // Засекаем время 
      // Запускаем таймер: 
      ueventid := timesetevent(delay,0,@proctime,0,1); 
      if ueventid=0 then 
        showmessage('Ошибка запуска таймера') 
    end; 
     
    procedure tfmexample.formactivate(sender: tobject); 
    begin 
      edinput.setfocus 
    end; 
     
    end. 


