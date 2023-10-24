@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">Dashboard</div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{$message}}
                </div>
                @else
                <div class="alert alert-success">
                    You are logged in!
                </div>
                @endif

                <div class="container">
                    <header class="text-center my-5">
                        <h1>Dzaki Achmad Abimanyu</h1>
                        <p class="lead">Software Engineering</p>
                    </header>

                    <section class="my-5">
                        <h2 class="text-primary">Proyek Terbaru</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h3 class="card-title">Aplikasi Mobile E-commerce</h3>
                                        <p class="card-text">Aplikasi mobile untuk belanja online dengan berbagai fitur canggih.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h3 class="card-title">Sistem Manajemen Inventaris</h3>
                                        <p class="card-text">Platform untuk melacak dan mengelola inventaris perusahaan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="my-5">
                        <h2 class="text-primary">Pendidikan</h2>
                        <p>Software Engineering</p>
                        <p>Universitas Gadjah Mada</p>
                        <p>2022 - 2026</p>
                    </section>

                    <section class="my-5">
                        <h2 class="text-primary">Kontak</h2>
                        <p>Email: dzakiachmad@example.com</p>
                        <p>LinkedIn: <a  class="text-primary">Dzaki Abimanyu</a></p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
