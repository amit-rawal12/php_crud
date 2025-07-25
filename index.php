<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-sm">
    <div class="card-header bg-dark  text-white">
      <h4 class="mb-0">🛒 Add New Product</h4>
    </div>
    <div class="card-body">
      <form id="productForm" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Brand</label>
            <select name="brand" class="form-select" required>
              <option value="">Select Brand</option>
              <option>Apple</option>
              <option>Samsung</option>
              <option>OnePlus</option>
            </select>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Model</label>
            <input type="text" name="model" class="form-control" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Price (₹)</label>
            <input type="number" name="price" class="form-control" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control">
          </div>

          <div class="col-md-4 mb-3">
            <label class="form-label">Image 1</label>
            <input type="file" name="image1" class="form-control" required>
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Image 2</label>
            <input type="file" name="image2" class="form-control" required>
          </div>
          <div class="col-md-4 mb-3">
            <label class="form-label">Image 3</label>
            <input type="file" name="image3" class="form-control" required>
          </div>
        </div>

        <button type="submit" class="btn btn-dark w-100">🚀 Submit Product</button>
      </form>

      <div id="response" class="mt-3"></div>
    </div>
  </div>
</div>

<script>
  const form = document.getElementById('productForm');
  const responseDiv = document.getElementById('response');

  form.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(form);
    try {
      const res = await fetch("http://localhost/Nearest_api/create.php", {
        method: "POST",
        body: formData
      });
      const result = await res.json();
      if (result.status === "success") {
        responseDiv.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
        form.reset();
      } else {
        responseDiv.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
      }
    } catch (err) {
      responseDiv.innerHTML = `<div class="alert alert-danger">❌ Error: ${err.message}</div>`;
    }
  });
</script>
</body>
</html>
