</main>
  <footer>

            JaMaVa
  </footer>
  <script>
  $(document).ready(function(){
  $("#tabla_id").DataTable({
      "pageLength":3,
      lengthMenu:[
      [3,10,25,50],
      [3,10,25,50]  
      ],
      "language":{
        "url":"https://cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"

      }
    });
  
  });  
  </script>
<script>
function borrar(id){
        Swal.fire({
            title: 'Desea borrar el registro?',
            showCancelButton: true,
            confirmButtonText: 'Si. Borrar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location="index.php?txtID="+id;
        } 
})      
}
</script>



</body>

</html>