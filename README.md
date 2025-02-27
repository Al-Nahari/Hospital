# نظام إدارة المستشفى

هذا المشروع هو نظام ويب بسيط لإدارة بيانات المستشفى باستخدام PHP وMySQL. يتيح النظام إدارة المرضى، والأطباء، والأقسام، والمواعيد، والمخزون، بالإضافة إلى توليد التقارير.

## المميزات

- **إدارة المرضى:** إضافة وحذف سجلات المرضى (الاسم، الرقم القومي، الجنس، العمر، التاريخ الطبي).
- **إدارة الأطباء:** إضافة وحذف بيانات الأطباء (الاسم، التخصص، الهاتف، جدول المواعيد).
- **إدارة الأقسام:** إضافة وحذف الأقسام مع عدد الأسرة المتاحة.
- **إدارة المواعيد:** حجز المواعيد بين المرضى والأطباء مع تحديد التاريخ والوقت والقسم.
- **إدارة المخزون:** إضافة وحذف عناصر المخزون الطبي (الاسم، الكمية، تاريخ الانتهاء، القسم).
- **توليد التقارير:** إنشاء تقارير للمواعيد، الأقسام أو المخزون بناءً على نطاق زمني محدد.

## المتطلبات

- خادم ويب يدعم PHP (مثل Apache).
- قاعدة بيانات MySQL.
- Bootstrap 5 (مضمنة عبر CDN لواجهة المستخدم).
