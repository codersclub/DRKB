---
Title: Вызов сишной функции с переменным числом параметров
Author: Владимир Переплетчик
Date: 01.01.2007
---


Вызов сишной функции с переменным числом параметров
===================================================

::: {.date}
01.01.2007
:::

Автор: Владимир Переплетчик

Комментарий к статье по поводу wsprintf

Сама по себе статья вызывает мало интереса, кроме того, что поднята
интересная проблема - вызов с-шной функции с переменным числом
параметров. В ответах с использованием массивов вообще, IMHO, ошибка -
на стек попадет адрес массива, а в с это совсем не то. Но решение
проблемы существует, правда надо ручками повозиться со стеком.
Приводимая ниже функция на скорую руку переделывается из работающей в
реальном проекте похожего буфера с-паскаль, но там функция в dll имеет
тип вызова cdecl и другие обязательные параметры, в связи с чем возможны
\"опечатки\"

    // Пишем функцию-переходник, маскируя с-шные "..." паскалевским
    // array of const
     
    function sprintf(out, fmt: Pchar; args: array of const): Integer;
    var
      I: Integer;
      BufPtr: Pchar;
      S: string;
      buf: array[0..1024] of char;
    begin
      BufPtr := buf;
      // Формируем буфер параметров. Можно, конечно, и прямо на стеке,
      // но головной боли слишком много - проще так
      for I := low(Par) to High(Par) do
        case Par[I].VType of
          vtInteger: // Здесь все просто - 4 байта на стек
            begin
              Integer(Pointer(BufPtr)^) := Par[I].VInteger;
              Inc(BufPtr, 4);
            end;
          vtExtended: // Здесь хуже - слова надо местами поменять :-((
            begin
              Integer(Pointer(BufPtr)^) :=
                Integer(Pointer(Pchar(Par[I].VExtended) + 4)^);
              Inc(BufPtr, 4);
              Integer(Pointer(BufPtr)^) :=
                Integer(Pointer(Par[I].VExtended)^);
              Inc(BufPtr, 4);
            end;
          vtPChar: // Здесь тоже все хорошо - 4 байта
            begin
              Pointer(Pointer(BufPtr)^) := Par[I].VPchar;
              Inc(BufPtr, 4);
            end;
          vtString, vtAnsiString: // А здесь во избежание чудес надо
            // копию строки снять
            begin
              if Par[I].VType = vtString then
                S := Par[I].VString^
              else
                S := string(Par[I].VAnsiString);
              Pointer(Pointer(BufPtr)^ :=
                StrPCopy(StrAlloc(Length(S) + 1), S);
                Inc(BufPtr, 4);
            end;
        end;
      // Поддержку других типов доделывать самостоятельно,
      // вооружившись толковым пособием по с и ассемблеру
     
      I := (BufPtr - buf) div 4; // Сколько раз на стек слово положить
     
      asm
          push dword ptr [out]
          push dword ptr [fmt]
          mov ecx, dword ptr [i]
          mov eax, dword ptr [buf]  // stdcall - параметры в прямом
                                    // порядке
          @@1:
          push dword ptr [eax]
          add  eax, 4
          loop @@1
          call [wsprintf]
          mov  dword ptr [Result], eax // Сохранить результат
          mov eax, dword ptr [i]       // Привести в порядок стек
          shl eax, 2
          add eax, 8
          add esp, eax
      end;
      // Почистить строки
      for I := low(Par) to High(Par) do
        case Par[I].VType of
          vtInteger: Inc(BufPtr, 4);
          vtExtended: Inc(BufPtr, 8);
          vtPChar: Inc(BufPtr, 4);
          vtString, vtAnsiString:
            begin
              StrDispose(PChar(PPointer(BufPtr)^));
              Inc(BufPtr, 4);
            end;
        end;
    end;

В таком виде методика уже имеет смысл. Изменения при типах вызова cdecl
/ pascal понятны.

Взято с <https://delphiworld.narod.ru>
