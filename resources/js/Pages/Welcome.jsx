import { Link, Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Welcome(props) {
    return (
        <>
            <Head title="Montink" />
        </>
    );
}

Produtos.layout = page => <AuthenticatedLayout children={page} />
