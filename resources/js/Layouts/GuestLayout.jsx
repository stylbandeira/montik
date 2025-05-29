import ApplicationLogo from '@/Components/ApplicationLogo';
import Header from '@/Components/Header';
import { Link } from '@inertiajs/react';

export default function Guest({ children }) {
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
