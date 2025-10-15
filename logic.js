const person = {
    name: "adit",
    pw: "1234",
};
function key(){
    const nama = document.getElementById("nama").value;
    const pwd = document.getElementById("pwd").value;
    interaksi(nama, pwd);
}
function interaksi(nama, pwd) {
  if(nama == person.name.toLowerCase() && pwd == person.pw){
    alert(`berhasil dan username anda ${nama} pasword anda ${pwd}`);
  }else{
    alert("salah ulangi dengan benar");
  }
}
