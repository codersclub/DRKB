---
Title: Криптоалгоритм DES
Date: 01.01.2007
---


Криптоалгоритм DES
==================

::: {.date}
01.01.2007
:::

Особенностью этой криптосистемы является использование операций
циклического сдвига, зависящих от преобразуемых данных RC5 \[12,13\].
Это задает непредопределенность операций преобразования, выполняемых над
преобразуемыми подблоками данных, что по замыслу разработчиков должно
привести к до-стижению высокой криптостойкости. В этой криптосистеме
пре-дусмотрена возможность задания пользователем числа раундов и размера
входного блока данных. Входной блок разбивается на два подблока
одинаковой длины. Обозначим длину подблока в битах через Ъ. Шифрование
заключается в поочередном преоб-разовании подблоков с использованием
операций поразрядно-го суммирования по модулю два, суммирования по
модулю 26 и управляемых операций циклического сдвига. Варианты опера-ции
циклического сдвига различаются величиной сдвига от 0 до Ь - 1 бит. Для
обозначения операции циклического сдвига подблока (слова) W на х бит
будем применять запись W \<\<\< х (сдвиг влево) и W \>\>\> х (сдвиг
вправо). Для выбора конкретной модификации операции циклического сдвига
используется log2 b младших разрядов управляющего блока.

На каждом раунде преобразования используется отдельная пара подключей,
поэтому при выборе различного числа раун-дов преобразования используется
ключ шифрования различной длины. Для удобства пользователей в шифре RC5
используется алгоритм инициализации, выполняемый однократно при запуске
криптосистемы. На этом этапе предвычислений по секретному ключу
пользователя в зависимости от заданного числа раундов R формируется ключ
шифрования в виде последовательности, содержащей 2(R+1) b-битовых
подключей. Подключи используются по фиксированному расписанию, т. е. для
всех входных блоков на данном шаге преобразования используется один и
тот же подключ. Для того, чтобы указать значения конкретных па-раметров
настройки алгоритма применяется запись RC5-b/R/l, где l -длина
секретного ключа в байтах.

Типичной является модификация RC5-32/12/16, ко-торая соответствует
64-битовому входному блоку данных, 128-битовому секретному ключу и 12
раундам шифрования. Эта модификация является стойкой к известным методам
криптоанализа и может применяться для защиты данных в
авто-матизированных системах обработки информации и управления. В случае
применения 64-разрядных микропроцессоров целе-сообразно применение
модификации RC5-64/12/16, которая обеспечит более высокую скорость
преобразования. Кроме того, при преобразовании 128-битовых блоков
исходного текста повышается стойкость шифрования за счет увеличения
числа управляющих битов с 5 до 6.

Алгоритм предвычислений формирует ключ шифрования необходимого размера,
при этом используются процедуры, которые обеспечивают влияние каждого
бита секретного ключа на каждый бит ключа шифрования. По значению клю-ча
шифрования трудно восстановить секретный ключ. Мы не будем
останавливаться на описании алгоритма предвы-числений, поскольку могут
быть применены различные его варианты. Рассмотрим процедуры шифрования и
дешифро-вания, которые составляют сущность криптосистемы RC5. Обозначим
ключ шифрования как последовательность подключей Q0, Q1, \..., Q2R+1.
Процедуры шифрования и дешифрования блока Т = A \| В описываются
следующими простыми алгоритмами:

BХОД: Исходное значение Ь-битовых подблоков A и В.

1\. Установить счетчик i == 1 и число раундов R и выполнить
преобразования:

А := (A + Qo) mod

2 b;

В := (B + Q1)mod2b.2. Преобразовать: A := {\[(A ф В)

\<\<\< В\] +Q2i}mod 2 bB := \[(B ф A) \< \< \< A\] + Q2i + 1} mod

2 b3.Если i? R, то прирастить i := i + 1 и перейти к шагу 2.4.

СТОП.

ВЫХОД: Преобразованное значение подблоков A и В.

Алгоритм дешифрования.

1\. Установить счетчик i = R.

2\. Преобразовать: B :=

{\[(В - Q2i+i) mod 2b\] \>\>\> A} Ф AA := {\[(A - Q2i ) mod2b\]

\>\>\> В} Ф В.3. Если i ? 1, то уменьшить на 1 значение счетчика

i := i - 1 и перейти к шагу 2.4. Преобразовать: B := (B - Q1)

mod2b;

A := (A - Q0) mod 2 b

Схема шифрующих преобразований одного раунда пред-ставлена на рис.
Операция циклического сдвига относится к быстрым элементарным операциям
современных процессоров, Кроме того, время выполнения операции
циклического сдвига не зависит от величины сдвига. При программной
реализации модификация RC5-32/12/16 обеспечивает скорость шифро-вания
порядка нескольких Мбайт/с для микропроцессора Pentium. В приведенных
алгоритмах не используются операция табличной подстановки, которые
являются типичными нели-нейными операциями для многих блочных
криптосистем, Нелинейными операциями рассмотренного шифра явля-ются
операции циклического сдвига, зависящие от пре-образуемых данных. Как
шифрование, так и дешифрова-ние начинается с выполнения операции над
подблоками и подключами. Это обусловливает различие в операци-ях
циклического сдвига на каждом раунде шифрования в дешифрования.
Двухместные операции (Ф), выполняемые над двумя подблоками, усиливают
эффект размножения ошибки.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0