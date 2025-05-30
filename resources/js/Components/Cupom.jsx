import axios from 'axios';
import { useEffect, useState } from 'react';

export default function Cupom() {
    const [cupom, setCupom] = useState('');

    const handleChange = (e) => {
        console.log('aa')
        // e.preventDefault();
    }

    // const handleCupom = (e) => {
    //     e.preventDefault()
    //     const response = axios.get('/api/cupons', {
    //         params: {
    //             codigo: cupom
    //         }
    //     });

    //     console.log(response);
    // }

    const handleCupom = async (e) => {
        e.preventDefault()
        const response = await axios.get('/api/cupons', {
            params: {
                codigo: cupom
            }
        });

        console.log(response.data);
    }

    return (
        <>
            <div className="m-2 w-100">
                <form className='w-100'>
                    <input
                        type="text"
                        className='w-100'
                        placeholder='Digite o Cupom'
                        onChange={(e) => setCupom(e.target.value)}
                    />

                    <button
                        onClick={handleCupom}
                        className='w-100 btn btn-success mt-2'
                    >
                        Aplicar Cupom
                    </button>
                </form>
            </div>
        </>
    );
}
