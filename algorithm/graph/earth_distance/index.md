---
Title: Расчет расстояния между 2-я точками на земной поверхности методом Винсенти
Author: Vit
Date: 08.09.2006
---


Расчет расстояния между 2-я точками на земной поверхности методом Винсенти
==========================================================================

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Расчет расстояния между двумя точками на земной поверхности.
     
    Расчет расстояния между 2мя точками на земной поверхности методом Винсенти.
     
     
    Dimka Maslov:
    Lat1, Lon1 - широта и долгота точки 1 в градусах
    Lat2, Lon2 - широта и долгота точки 2 в градусах
    Функция возвращает результат в метрах.
     
    Автор, правда, забыл упомянуть о правиле знаков для южных широт и западных
    долгот...
     
     
    Зависимости: Math
    Автор:       Вячеслав
    Copyright:   Опубликован в Survey Review №175 за Апрель 1976г.
    Дата:        19 марта 2003 г.
    ********************************************** }
     
    function Vincenty(Lat1, Lon1, Lat2, Lon2: Extended): Extended;
    const // Параметры эллипсоида:
      a = 6378245.0;
      f = 1 / 298.3;
      b = (1 - f) * a;
      EPS = 0.5E-30;
    var
     APARAM, BPARAM, CPARAM, OMEGA, TanU1, TanU2,
     Lambda, LambdaPrev, SinL, CosL, USQR, U1, U2,
     SinU1, CosU1, SinU2, CosU2, SinSQSigma, CosSigma,
     TanSigma, Sigma, SinAlpha, Cos2SigmaM, DSigma : Extended;
    begin
     lon1 := lon1 * (PI / 180);
     lat1 := lat1 * (PI / 180);
     lon2 := lon2 * (PI / 180);
     lat2 := lat2 * (PI / 180); //Пересчет значений координат в радианы
     TanU1 := (1 - f) * Tan(lat1);
     TanU2 := (1 - f) * Tan(lat2);
     U1 := ArcTan(TanU1);
     U2 := ArcTan(TanU2);
     SinCos(U1, SinU1, CosU1);
     SinCos(U2, SinU2, CosU2);
     OMEGA := lon2 - lon1;
     lambda := OMEGA;
     repeat //Начало цикла итерации
      LambdaPrev:= lambda;
      SinCos(lambda, SinL, CosL);
      SinSQSigma := (CosU2 * SinL * CosU2 * SinL) +
       (CosU1 * SinU2 - SinU1 * CosU2 * CosL) *
       (CosU1 * SinU2 - SinU1 * CosU2 * CosL);
      CosSigma := SinU1 * SinU2 + CosU1 * CosU2 * CosL;
      TanSigma:= Sqrt(SinSQSigma) / CosSigma;
      if TanSigma > 0
       then Sigma := ArcTan(TanSigma)
       else Sigma := ArcTan(TanSigma) + Pi;
      if SinSQSigma = 0
       then SinAlpha := 0
        else SinAlpha := CosU1 * CosU2 * SinL / Sqrt(SinSQSigma);
      if (Cos(ArcSin(SinAlpha)) * Cos(ArcSin(SinAlpha))) = 0
       then Cos2SigmaM := 0
       else Cos2SigmaM:= CosSigma -
        (2 * SinU1 * SinU2 / (Cos(ArcSin(SinAlpha)) * Cos(ArcSin(SinAlpha))));
      CPARAM:= (f / 16) * Cos(ArcSin(SinAlpha)) * Cos(ArcSin(SinAlpha)) *
       (4 + f * (4 - 3 * Cos(ArcSin(SinAlpha)) * Cos(ArcSin(SinAlpha))));
      lambda := OMEGA + (1 - CPARAM) * f * SinAlpha * (ArcCos(CosSigma) +
       CPARAM * Sin(ArcCos(CosSigma)) * (Cos2SigmaM + CPARAM * CosSigma *
       (-1 + 2 * Cos2SigmaM * Cos2SigmaM)));
     until Abs(lambda - LambdaPrev) < EPS; // Конец цикла итерации
     USQR:= Cos(ArcSin(SinAlpha)) * Cos(ArcSin(SinAlpha)) *
      (a * a - b * b) / (b * b);
     APARAM := 1 + (USQR / 16384) *
      (4096 + USQR * (-768 + USQR * (320 - 175 * USQR)));
     BPARAM := (USQR / 1024) * (256 + USQR * (-128 + USQR * (74 - 47 * USQR)));
     DSigma := BPARAM * SQRT(SinSQSigma) * (Cos2SigmaM + BPARAM / 4 *
      (CosSigma * (-1 + 2 * Cos2SigmaM * Cos2SigmaM) - BPARAM / 6 * Cos2SigmaM *
      (-3 + 4 * SinSQSigma) * (-3 + 4 * Cos2SigmaM * Cos2SigmaM)));
     Result := b * APARAM * (Sigma - DSigma);
    end; 

Пример использования:

    procedure TForm1.Button1Click(Sender: TObject);
    var
     R: Extended;
    begin
     R := Vicenty(59.8833, 30.2333, 55.7667, 37.5833);
     ShowMessageFmt('%g', [R]);
    end; 

------------------------------------------------------------------------

Вариант 2.

Random

недавно пришлось решать похожую задачку, однако приведенные вычисления
слишком громоздкие, вот формула попроще:

    distance=sqrt(pow((lon1 - lon2)*111*COS(lat2/57.295781), 2) + pow((lat1) - lat)*111, 2))

проверялась по google maps (собственно для интеграции с ними и
используется), расхождение составило не более 1,5%

можно еще уточнить, если брать косинус не от одной широты а от их
разности... но и так работает достаточно точно. Извиняюсь за
недельфийский синтаксис (писал в mySQL), но думаю несложно будет
перевести =). lat2/57.295781 - чтобы получить широту в радианах (опять
же для mySQL).

Широта и долгота передается в формате google maps, то есть как
вещественное число со знаком, размерность - градусы. Результат - в
километрах.

------------------------------------------------------------------------
Вариант 2:

Попробуйте следующий код. Я им пользуюсь продолжительное время.

Входные данные:

    StartLat (начальная широта) = Градусы и сотые доли
    StartLong (начальная долгота) = Градусы и сотые доли
    EndLat (конечная широта) = Градусы и сотые доли
    EndLong (конечная долгота) = Градусы и сотые доли

Выходные данные:

    Distance (расстояние) = Расстояние в метрах
    Bearing (смещение) = Смещение в градусах

Не забудьте включить модуль Math в список используемых (USES) модулей.

    var
      // Передаваемые широта/долгота в градусах и сотых долях
      StartLat: double; // Начальная широта
      StartLong: double; // Начальная долгота
      EndLat: double; // Конечная широта
      EndLong: double; // Конечная долгота
     
      // Переменные, используемые для вычисления смещения и расстояния
      fPhimean: Double; // Средняя широта
      fdLambda: Double; // Разница между двумя значениями долготы
      fdPhi: Double; // Разница между двумя значениями широты
      fAlpha: Double; // Смещение
      fRho: Double; // Меридианский радиус кривизны
      fNu: Double; // Поперечный радиус кривизны
      fR: Double; // Радиус сферы Земли
      fz: Double; // Угловое расстояние от центра сфероида
      fTemp: Double; // Временная переменная, использующаяся в вычислениях
      Distance: Double; // Вычисленное расстояния в метрах
      Bearing: Double; // Вычисленное от и до смещение
    end
     
    const
      // Константы, используемые для вычисления смещения и расстояния
      D2R: Double = 0.017453; // Константа для преобразования градусов в радианы
      R2D: Double = 57.295781; // Константа для преобразования радиан в градусы
      a: Double = 6378137.0; // Основные полуоси
      b: Double = 6356752.314245; // Неосновные полуоси
      e2: Double = 0.006739496742337; // Квадрат эксцентричности эллипсоида
      f: Double = 0.003352810664747; // Выравнивание эллипсоида
     
    begin
      // Вычисляем разницу между двумя долготами и широтами и получаем среднюю широту
      fdLambda := (StartLong - EndLong) * D2R;
      fdPhi := (StartLat - EndLat) * D2R;
      fPhimean := ((StartLat + EndLat) / 2.0) * D2R;
     
      // Вычисляем меридианные и поперечные радиусы кривизны средней широты
      fTemp := 1 - e2 * (Power(Sin(fPhimean), 2));
      fRho := (a * (1 - e2)) / Power(fTemp, 1.5);
      fNu := a / (Sqrt(1 - e2 * (Sin(fPhimean) * Sin(fPhimean))));
     
      // Вычисляем угловое расстояние
      fz :=
        Sqrt(Power(Sin(fdPhi / 2.0), 2) + Cos(EndLat * D2R) * Cos(StartLat * D2R) *
          Power(Sin(fdLambda / 2.0), 2));
     
      fz := 2 * ArcSin(fz);
     
      // Вычисляем смещение
      fAlpha := Cos(EndLat * D2R) * Sin(fdLambda) * 1 / Sin(fz);
      fAlpha := ArcSin(fAlpha);
     
      // Вычисляем радиус Земли
      fR := (fRho * fNu) / ((fRho * Power(Sin(fAlpha), 2)) + (fNu *
        Power(Cos(fAlpha), 2)));
     
      // Получаем смещение и расстояние
      Distance := (fz * fR);
      if ((StartLat < EndLat) and (StartLong < EndLong)) then
        Bearing := Abs(fAlpha * R2D)
      else if ((StartLat < EndLat) and (StartLong > EndLong)) then
        Bearing := 360 - Abs(fAlpha * R2D)
      else if ((StartLat > EndLat) and (StartLong > EndLong)) then
        Bearing := 180 + Abs(fAlpha * R2D)
      else if ((StartLat > EndLat) and (StartLong < EndLong)) then
        Bearing := 180 - Abs(fAlpha * R2D);
    end;
     

<https://delphiworld.narod.ru/>


------------------------------------------------------------------------

Вариант 3:

Пришлось решать похожую задачу, только в разрезе баз данных.

Представьте себе, что у вас таблица например адресов магазинов, и по требованию
клиента вам надо выбрать все которые расположены не далее чем в радиусе
5 км. Если магазинов (или офисов) всего несколько тысяч, то проблем нет,
даже простой перебор не проблема, а в моей задаче их было 20
миллионов...

Вычислять расстояние по приведенным выше формулам 20
миллионов раз? Хм... сервер задумывался минут на 10, причём страдала и
общая производительность системы.

Итогом проб стал следующий алгоритм -
1 градус широты вещь фиксированная в плане расстояния, протяжённость же
одиного градуса долготы зависит от широты, но можно грубо прикинуть для
каждых 10 градусов широты сколько составляет длина градуса долготы.

Теперь в таблице проводим очень быстрый поиск по заранее
проиндексированным полям долготы и широты, причём указываем заведомо
бульший участок в ввиде неровного квадрата на земном шаре, а потом уже
по приведенным выше формулам можно найти точные расстояния среди очень
ограниченного числа значений.

Мне удалось добиться таким образом
увеличения производительности на 2-3 порядка.

Автор: Vit
