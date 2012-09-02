<h1>Математика, статистика и финансы</h1>
<div class="date">01.01.2007</div>


<p>Тригонгометрические функции:</p>

<p>function ArcCos(X: Extended): Extended;</p>
<p>function ArcSin(X: Extended): Extended;</p>
<p>function ArcTan2(Y, X: Extended): Extended; Арктангенс X/Y возвращает угол в квадранте</p>
<p>procedure SinCos(Theta: Extended; var Sin, Cos: Extended) register; возвращает сразу и синус и косинус, вычисления в 2 раза быстрее чем Sin, Cos по отдельности</p>
<p>function Tan(X: Extended): Extended;</p>
<p>function Cotan(X: Extended): Extended;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>function Hypot(X, Y: Extended): Extended;&nbsp; Возвращает значение гипотенузы по катетам</p>

<p>Конвертация углов</p>

<p>function DegToRad(Degrees: Extended): Extended; </p>
<p>function RadToDeg(Radians: Extended): Extended;&nbsp; </p>
<p>function GradToRad(Grads: Extended): Extended;&nbsp; </p>
<p>function RadToGrad(Radians: Extended): Extended; </p>
<p>function CycleToRad(Cycles: Extended): Extended; </p>
<p>function RadToCycle(Radians: Extended): Extended;</p>

<p>Гиперболические функции</p>

<p>function Cosh(X: Extended): Extended;</p>
<p>function Sinh(X: Extended): Extended;</p>
<p>function Tanh(X: Extended): Extended;</p>
<p>function ArcCosh(X: Extended): Extended; </p>
<p>function ArcSinh(X: Extended): Extended;</p>
<p>function ArcTanh(X: Extended): Extended;&nbsp;&nbsp; </p>

<p>Логарифмы, экспоненты и возведение в степень</p>

<p>function LnXP1(X: Extended): Extended;&nbsp; - натуральный логариф x+1 (для более высокой точности при x близких к нулю)</p>
<p>function Log10(X: Extended): Extended; - десятичный логарифм&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>function Log2(X: Extended): Extended;&nbsp; - логарифм по основанию 2</p>
<p>function LogN(Base, X: Extended): Extended; - логарифм по произвольному основанию</p>
<p>function IntPower(Base: Extended; Exponent: Integer): Extended register;</p>
<p>function Power(Base, Exponent: Extended): Extended;</p>

<p>Разные функции</p>

<p>procedure Frexp(X: Extended; var Mantissa: Extended; var Exponent: Integer) register; - возвращает мантису и экспоненту</p>
<p>function Ldexp(X: Extended; P: Integer): Extended register; - возвращает X*2**P</p>
<p>function Ceil(X: Extended):Integer; - округляет до ближайшего большего целого</p>
<p>function Floor(X: Extended): Integer; - округляет до ближайшего меньшего целого</p>
<p>function Poly(X: Extended; const Coefficients: array of Double): Extended; вычисление полинома</p>

<p>Статистические функции</p>

<p>function Mean(const Data: array of Double): Extended; среднее арифметическое</p>
<p>function Sum(const Data: array of Double): Extended register; сумма ряда</p>
<p>function SumInt(const Data: array of Integer): Integer register; сумма ряда целых чисел</p>
<p>function SumOfSquares(const Data: array of Double): Extended; сумма квадратов</p>
<p>procedure SumsAndSquares(const Data: array of Double;&nbsp; var Sum, SumOfSquares: Extended) register; сумма и сумма квадратов одной функцией</p>
<p>function MinValue(const Data: array of Double): Double; минимальное значение в ряду</p>
<p>function MinIntValue(const Data: array of Integer): Integer; минимальное значение в ряду целых</p>
<p>function Min(A,B) минимальное значение из 2х чисел (overload функции для Integer, Int64, Single, Double, Extended)</p>
<p>function MaxValue(const Data: array of Double): Double;</p>
<p>function MaxIntValue(const Data: array of Integer): Integer;</p>
<p>function Max(A,B);</p>
<p>function StdDev(const Data: array of Double): Extended; стандартное отклонение</p>
<p>procedure MeanAndStdDev(const Data: array of Double; var Mean, StdDev: Extended); - среднее арифметическое и стандартное отклонение</p>
<p>function PopnStdDev(const Data: array of Double): Extended; распределение стандартного отклонения (Population Standard Deviation)</p>
<p>function Variance(const Data: array of Double): Extended;</p>
<p>function PopnVariance(const Data: array of Double): Extended; (Population Variance)</p>
<p>function TotalVariance(const Data: array of Double): Extended;</p>
<p>function Norm(const Data: array of Double): Extended; среднее квадратичное (Sqrt(SumOfSquares))</p>
<p>procedure MomentSkewKurtosis(const Data: array of Double;</p>
<p>  var M1, M2, M3, M4, Skew, Kurtosis: Extended); основные статистические моменты</p>
<p>function RandG(Mean, StdDev: Extended): Extended; - случайные числа с Гауссовским распределением</p>

<p>Финансовые функции</p>

<p>function DoubleDecliningBalance(Cost, Salvage: Extended;&nbsp; Life, Period: Integer): Extended;</p>
<p>function FutureValue(Rate: Extended; NPeriods: Integer; Payment, PresentValue:&nbsp; Extended; PaymentTime: TPaymentTime): Extended;</p>
<p>function InterestPayment(Rate: Extended; Period, NPeriods: Integer; PresentValue,</p>
<p>  FutureValue: Extended; PaymentTime: TPaymentTime): Extended;</p>
<p>function InterestRate(NPeriods: Integer;</p>
<p>  Payment, PresentValue, FutureValue: Extended; PaymentTime: TPaymentTime): Extended;</p>
<p>function InternalRateOfReturn(Guess: Extended;</p>
<p>  const CashFlows: array of Double): Extended;</p>
<p>function NumberOfPeriods(Rate, Payment, PresentValue, FutureValue: Extended;</p>
<p>  PaymentTime: TPaymentTime): Extended;</p>
<p>function NetPresentValue(Rate: Extended; const CashFlows: array of Double;</p>
<p>  PaymentTime: TPaymentTime): Extended;</p>
<p>function Payment(Rate: Extended; NPeriods: Integer;</p>
<p>  PresentValue, FutureValue: Extended; PaymentTime: TPaymentTime): Extended;</p>
<p>function PeriodPayment(Rate: Extended; Period, NPeriods: Integer;</p>
<p>  PresentValue, FutureValue: Extended; PaymentTime: TPaymentTime): Extended;</p>
<p>function PresentValue(Rate: Extended; NPeriods: Integer;</p>
<p>  Payment, FutureValue: Extended; PaymentTime: TPaymentTime): Extended;</p>
<p>function SLNDepreciation(Cost, Salvage: Extended; Life: Integer): Extended;</p>
<p>function SYDDepreciation(Cost, Salvage: Extended; Life, Period: Integer): Extended;</p>

