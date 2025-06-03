import ApplicationLogo from '@/Components/ApplicationLogo';
import Header from '@/Components/Header';
import { Link } from '@inertiajs/react';
import { useEffect, useState } from 'react';

export default function Guest({ children }) {
    const [carrinho, setCarrinho] = useState([]);

    useEffect(() => {
        setCarrinho(JSON.parse(localStorage.getItem('carrinho')));
    }, []);

    return (
        <>
            <nav className="navbar navbar-expand-lg navbar-dark bg-dark p-4">
                <div className="container-fluid">
                    <Link className="navbar-brand" href="/">
                        Montink
                    </Link>
                    <div className="navbar-expand-md" id="navbarNav">
                        <ul className="navbar-nav ms-auto">
                            <li className="nav-item">
                                <Link className="nav-link active" href="/comprar">
                                    Comprar
                                </Link>
                            </li>

                            <li className="nav-item">
                                <Link className="nav-link active" href="/pedidos">
                                    <button className="btn position-relative">
                                        <i className="bi bi-cart"></i>
                                        {carrinho.length > 0 && (
                                            <span className="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                {carrinho.length}
                                            </span>
                                        )}
                                    </button>
                                </Link>
                            </li>

                            <li className="nav-item">
                                <Link className="nav-link active" href="/login">
                                    Login
                                </Link>
                            </li>

                            <li className="nav-item">
                                <Link className="nav-link active" href="/register">
                                    Register
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>


            <main className='container my-5'>
                {children}
            </main>
        </>
    );
}
