---
Title: Защита программы паролем
Date: 01.01.2007
Source: http://www.delphi.h5.ru/
---


Защита программы паролем
========================

Как видно из примера, программист может поместить любой код до обращения
к методу application.run. В частности, он может показать диалоговое окно
с запросом пароля и блокировать вызов application.run, если введенный
пользователем пароль неверен. В следующем примере (листинг 4 -
password.dpr) в проекте используются две формы: стандартная форма
inputquery и главная форма mainform. Форма inputquery создается при
обращении к одноименной функции, определенной в модуле dialogs. Она
представляет собой небольшое диалоговое окно с однострочным редактором
tedit и двумя кнопками --- ОК и cancel. В окне пользователь должен
ввести пароль (delphi) и нажать enter.

Листинг 4

    program password; 
     
    uses 
    forms, 
    dialogs, // В этом модуле определена функция inputquery 
    unit1 in 'unit1.pas' {mainform}; 
     
    {$r *.res} 
    var 
    passwrd: string; 
    begin 
    // Запрашиваем пароль: 
    if inputquery('Окно ввода пароля','Введите пароль:',passwrd) then 
    // Проверяем его: 
    if passwrd = 'delphi' then 
    begin // Все в порядке, пароль верен 
    application.createform(tmainform, mainform); 
    application.run; 
    end else 
    showmessage('Пароль не верен!'); 
    end. 


Пробные версии программ

Вышеописанным способом можно создавать пробные версии программ, которые
будут функционировать только до определенной даты или до исчерпания
заданного количества запусков. В листинге 5 представлен файл проекта
(trial.dpr), в котором пробная версия программы может запускаться не
более 5 раз. Для запоминания номера очередного прогона используется
системный реестр.

Листинг 5

    program trial; 
     
    uses 
      forms, 
      unit1 in 'unit1.pas' {form1}, 
      registry, dialogs; // Для tregistry и showmessage 
     
    {$r *.res} 
    var 
      reg: tregistry; 
      n: integer; 
    begin 
      reg := tregistry.create; 
      with reg do 
      begin 
        openkey('software', true); 
        openkey('trialprog', true); 
        if valueexists('maxrun') then // Первый запуск? 
        begin // - Нет 
          n := readinteger('maxrun')-1; 
          if n>=0 then 
            writeinteger('maxrun', n) 
        end else begin // -Да, первый запуск 
          n := 5; 
          writeinteger('maxrun', n) 
        end; 
        free 
      end; 
      if n>0 then 
      begin 
        application.createform(tform1, form1); 
        application.run; 
      end else 
        showmessage('Исчерпано максимальное количество запусков'+ 
                    ' пробной версии программы') 
    end. 

Здесь следует дать небольшой комментарий. Модуль registry декларирует
класс tregistry, который представляет программисту доступ к системному
реестру windows. С помощью двух обращений к функции tregistry.openkey
создается и/или открывается ключ hkey\_current\_usersoftwaretrialprog
системного реестра. Функция tregistry.valueexists возвращает true, если
этот ключ содержит параметр с именем maxrun и для него определено
значение. При первом запуске приложения это не так, поэтому процедурой
writeinteger создается параметр и для него указывается начальное
значение 5 (максимальное количество прогонов программы). При каждом
следующем запуске этот параметр уменьшается на 1 и в момент, когда он
становится равен 0, приложение блокирует создание и отображение главного
окна.

