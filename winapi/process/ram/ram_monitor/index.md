---
Title: Пишем программу мониторинга за памятью
Author: Crazy_Script, crazy_script@mail.ru
Date: 01.01.2007
Source: http://delphi.dax.ru
---

Пишем программу мониторинга за памятью
======================================

Сегодня мы попытаемся написать программу, которая будет показывать
состояние памяти компа.

Для начала определим что она будет делать.
Ну, самое главное что нам нужно, это сотояние физической памяти и
загруженность ее в %. А дальше, по своему вкусу, добавим еще состояние
виртуальной и страничной памяти. Начнем. Создай новый проект на Делфи (
File-\>New-\>Application). Теперь подумай, как тебе удобней отображать
состояние памяти. Для меня лучше в Label, но можно и Edit. Ну это на
твое усмотрение. Кидай на форму 7 компонентов Label (в них будет
отображаться значение) и еще 7 (это будут пояснения: загруженность,
всего физической, использовано физической, всего страничной,
использовано страничной, всего виртуальной, использовано виртуальной).
Какие не нужны, те отбрось ;) . Теперь кинь таймер (из вкладки System).
Это будет наш главный элемент., поэтому поставь интервал по своему
усмотрению (у меня он 400). Этот интервал будет отвечать за частоту
обновления полей. Ну и для красоты брось ProgressBar ( из вкладки
Win32). У тебя должно получиться что-то типа этого: Теперь приступим
непосредственно к кодингу. Весь код мы будем писать в процедуру запуска
таймера.

А вот и код:

    procedure TForm1.Timer1Timer(Sender: TObject); 
      var m: TMemoryStatus; temp: integer; 
    begin
      m.dwLength:=sizeof(m); 
      GlobalMemoryStatus(m); 
      with m do begin //Загруженность памяти 
        label1.caption:=IntToStr (dwMemoryLoad)+' %'; // Всего физической 
        label2.caption:=IntToStr (dwTotalPhys)+' байт'; // Свободно физической 
        label3.caption:=IntToStr (dwAvailPhys)+' байт'; // Всего страничной 
        label4.caption:=IntToStr (dwTotalPageFile)+' байт'; // Свободно страничной 
        label5.caption:=IntToStr (dwAvailPageFile)+' байт'; // Всего выиртуальной 
        label6.caption:=IntToStr (dwTotalVirtual)+' байт'; //Свободно виртуальной 
        label7.caption:=IntToStr (dwAvailVirtual)+' байт'; //Загруженность на ProgressBar1 
        progressbar1.Max:= dwTotalPhys; 
        progressbar1.Position:=dwTotalPhys-dwAvailPhys; 
      end; 
    end; 

Вот в принципе и все. Если ты используешь Edit, то вместо labelX.caption
пиши EditX.text, где х-номер компонента. И последнее, чтобы pogressBar
выглядела лучше, измени свойство Smooth равным True. Если у тебя
возникнут какие-либо вопросы, предложения, пожелания, прошу отправлять
их мне по адресу: crazy\_script@mail.ru

