import React from 'react';
import { Link } from '@inertiajs/react';

export default function Header() {
    return (
        <nav className="navbar navbar-expand-lg navbar-dark bg-dark p-4">
            <div className="container-fluid">
                <Link className="navbar-brand" href="/">
                    Montink
                </Link>
                <div className="navbar-expand-md" id="navbarNav">
                    <ul className="navbar-nav ms-auto">
                        <li className="nav-item">
                            <Link className="nav-link active" href="/produtos">
                                Produtos
                            </Link>
                        </li>
                        <li className="nav-item">
                            <Link className="nav-link" href="/sobre">
                                Sobre
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
}
