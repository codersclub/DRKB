---
Title: Защита shareware-программ
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Защита shareware-программ
==========================

Взято из FAQ: <https://blackman.km.ru/myfaq/cont4.phtml>

В качестве примера приведен небольшой участок программного кода,
позволяющий быстро создать защиту для программ SHAREWARE,
которая не влияет на функциональность самой программы,
но настоятельно «просит» ее зарегистрировать и закрывает при каждом
повторном запуске.

Технология данного метода заключается в том, что пользователь
может запустить программу только один раз за текущий сеанс Windows.
Используйте обработчик события FormShow:

    procedure TForm1.FormShow(Sender: TObject);
    var
      atom: integer;
      CRLF: string;
    begin
      if GlobalFindAtom('THIS_IS_SOME_OBSCUREE_TEXT') = 0 then
        atom := GlobalAddAtom('THIS_IS_SOME_OBSCUREE_TEXT')
      else
        begin
          CRLF := #10 + #13;
          ShowMessage('Данная версия предусматривает только один запуск'
            + 'в текущем сеансе Windows.' + CRLF
            + 'Для повторного запуска необходимо перезапустить Windows, или,'
            + CRLF + 'что лучше, - ' + CRLF + 'ЗАРЕГИСТРИРУЙТЕСЬ !');
          Close;
        end;
    end;

Преимущество данного метода в том, что пользователю доступны все
возможности программы, но только до момента ее закрытия, или перезапуска
системы.

Вся хитрость заключается в сохранении некоторой строки в системных
глобальных переменных («атомах») и последующей проверке ее в таблице
«атомов» системы.

