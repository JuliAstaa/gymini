PROJECT UAS DENGAN MENGAMBIL SISTEM MANAJEMEN GYM YANG KAMI NAMAI GYMINI

ANGGOTA
I MADE JULI ASTAWA (2401010239)
I NENGAH SAITYA SADIPTA (240101023)
I MADE INDRAWA (240101023)

CATATAN:
API
==================================AUTH==========================================

1. register untuk kasir, member, admin = http://localhost/gymini/backend/api/auth/register.php pakai METHOD "POST" pada body tolong sesuaikan dengan json ini
   {
   "email": "isi email",
   "username": "isi username",
   "password": "password",
   "role": "role"
   }

2. login = http://localhost/gymini/backend/api/auth/login.php pakai METHOD "POST" dan isi body json
   {  
   "identity": "bisa berupa username atau email",
   "password": "ya ini pw"
   }

==================================KASIR=========================================

1. get all data kasir = http://localhost/gymini/backend/api/kasir/get-data-kasir.php pakai METHOD GET

2. get data kasir by id = http://localhost/gymini/backend/api/kasir/get-data-kasir.php?id=isi id pakai method GET

3. update data kasir = http://localhost/gymini/backend/api/kasir/update-kasir.php pakai method PATCH, body json
   {
   "email": "emailnyaa",
   "username": "usernamenya",
   "password": "pw",
   "role": "role",
   "user_id": id (int)
   }

4. delele data kasir = http://localhost/gymini/backend/api/kasir/delete-kasir.php?id=id(int) pake method DELETE

=================================MEMBER=========================================

1. get all data member = http://localhost/gymini/backend/api/member/get-data-member.php pakai method GET

2. get data member by id = http://localhost/gymini/backend/api/member/get-data-member.php?id=id(int) pakai method GET

3. create data member = http://localhost/gymini/backend/api/member/create-member.php pakai method POST json:
   {
   "nama": "nama",
   "noTelp": "",
   "jk": "P / L", // sesuaikan
   "tglLahir": "",
   "user_id": //sesuaikan dengan id user saat registerasi
   }

4. update data member = http://localhost/gymini/backend/api/member/update-member.php pakai method PATCH json
   {
   "nama": "",
   "noTelp": "",
   "jk": "",
   "tglLahir": "",
   "member_id": id member nya (int)
   }

5. delete data member = http://localhost/gymini/backend/api/member/delete-member.php?id=id(int) pakai method DELETE

==============================================membership plan===========================================

1. get all data membership plan = http://localhost/gymini/backend/api/membership_plan/get-membership-plan.php pakai method GET

2. get data membership by id = http://localhost/gymini/backend/api/membership_plan/get-membership-plan.php?id=id(int) pakai method GET

3. create membership plan = http://localhost/gymini/backend/api/membership_plan/create-membership-plan.php pakai method POST, json:
   {
   "nama_paket": "", // string
   "harga_paket": , // int
   "durasi_hari": , // int
   "deskripsi": "" // string
   }

4. update membership plan = http://localhost/gymini/backend/api/membership_plan/update-membership-plan.php pakai method PATCH, json:
   {
   "nama_paket": "", // string
   "harga_paket": , // int
   "durasi_hari": , // int
   "deskripsi": "", // string
   "plan_id": //int
   }

5. delete membership plan = http://localhost/gymini/backend/api/membership_plan/delete-membership-plan.php?id=id(int) pakai method DELETE

==============================================Member membership====================================================

1. get membership = http://localhost/gymini/backend/api/member_membership/get-membership-data.php pakai method GET

2. get data membership by id membership = http://localhost/gymini/backend/api/member_membership/get-membership-data.php?id=id(int) pakai method GET

3. get data membership by id member = http://localhost/gymini/backend/api/member_membership/get-membership-data.php?idMember=idMember(int) pakai method GET

4. create member membership = http://localhost/gymini/backend/api/member_membership/create-member-membership.php pakai method POST, json:
   {
   "plan_id": , //int
   "members_id": , //int
   "status_pembayaran": "" //Belum Lunas / Lunas
   }

5. update status pembayaran membership = http://localhost/gymini/backend/api/member_membership/update-status-pembayaran.php pakai method PATCH, json:
   {
   "id_memberships": // int
   }

===========================================================transaction==============================================

1. get all transaction = http://localhost/gymini/backend/api/transaction/get-transaction.php pakai method GET

2. get transaction by id transaction = http://localhost/gymini/backend/api/transaction/get-transaction.php?id=id(int) pakai method GET

3. create transaction = http://localhost/gymini/backend/api/transaction/create-transaction.php pakai method POST, json:
   {
   "members_id": , // int
   "plan_id": , // int
   "payment_method": "", // Transfer / Cash
   "description": "" // string bisa null
   }

NOTE UNTUK REGISTERASI MEMBER
setelah registerasi di auth langsung arahkan ke registerasi lanjutan member yang sudah berisi id_user
