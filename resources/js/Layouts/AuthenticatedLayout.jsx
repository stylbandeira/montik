import { useState } from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import { Link } from '@inertiajs/react';

export default function Authenticated({ auth, header, children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

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
                                <Link className="nav-link active" href="/produtos">
                                    Produtos
                                </Link>
                            </li>

                            <li className="nav-item">
                                <Link className="nav-link active" href="/cupons">
                                    Cupons
                                </Link>
                            </li>

                            <li className="nav-item">
                                <Link className="nav-link active" href="/logout">
                                    Logout
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
